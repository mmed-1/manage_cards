<!DOCTYPE html>
<html lang="en">
<x-head title="Annuaire des comptes">
    <link rel="stylesheet" href="{{ asset('css/comptes.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</x-head>
<body>
    <div class="app-container">
        <!-- Left Sidebar -->
        <aside class="sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="logo-icon">A</span>
                    <span class="logo-text">AdminPanel</span>
                </div>
                <button class="close-sidebar-btn" id="closeSidebarBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="has-submenu active">
                        <div class="submenu-toggle">
                            <i class="fas fa-user"></i> 
                            <span>Gestion de Compte</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.addAcc') }}"><i class="fas fa-plus-circle"></i>Ajout de Compte</a></li>
                            <li class="active"><a href="{{ route('compte.details') }}"><i class="fas fa-list"></i>Consulter les Comptes</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <div class="submenu-toggle">
                            <i class="fas fa-server"></i> 
                            <span>Gestion des Equipements</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('ajout') }}"><i class="fas fa-plus-circle"></i> Ajout Equipement</a></li>
                            <li><a href="{{ route('consultation') }}"><i class="fas fa-list"></i> Consulter Equipement</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <div class="submenu-toggle">
                            <i class="fas fa-sim-card"></i> 
                            <span>Cartes BLR</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('admin-blr.add') }}"><i class="fas fa-plus-circle"></i> Ajout SIM BLR</a></li>
                            <li><a href="{{ route('details.blr') }}"><i class="fas fa-list"></i> Consulter Cartes BLR</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <div class="mobile-toggle" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="page-title">
                    <h1>Annuaire des comptes</h1>
                    <p>Gérer les comptes utilisateurs</p>
                </div>
                <div class="top-actions">
                    <button id="userMenuToggle" class="user-menu-toggle">
                        <i class="fas fa-user-circle"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <div class="card">
                    <div class="card-header">
                        <div class="search-container">
                            <form action="{{ route('search.acc') }}" method="post" class="search-form">
                                @csrf
                                <div class="search-input-group">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        placeholder="Rechercher un client par son nom ou son email"
                                        class="search-input"
                                    />
                                    <button type="submit" class="search-button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Status Messages -->
                        @if (session('delete'))
                            <div class="status-message {{ session('status') === 'success' ? 'success' : 'error' }} animate-in">
                                <div class="status-icon">
                                    <i class="{{ session('status') === 'success' ? 'fas fa-check-circle' : 'fas fa-times-circle' }}"></i>
                                </div>
                                <div class="status-content">
                                    <h3>{{ session('status') === 'success' ? 'Succès!' : 'Erreur!' }}</h3>
                                    <p>{{ session('status') === 'success' ? 'Le compte est bien supprimé' : 'Il y a un problème' }}</p>
                                </div>
                            </div>
                        @endif

                        @if (session('create'))
                            @switch(session('status'))
                                @case('success0')
                                    <div class="status-message success animate-in">
                                        <div class="status-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="status-content">
                                            <h3>Succès!</h3>
                                            <p>Le compte est bien modifié. <br> Un email est envoyé!</p>
                                        </div>
                                    </div>
                                    @break
                                @case('success1')
                                    <div class="status-message success animate-in">
                                        <div class="status-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="status-content">
                                            <h3>Succès!</h3>
                                            <p>Le compte est bien modifié.</p>
                                        </div>
                                    </div>
                                    @break
                            @endswitch
                        @endif

                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Nom de compte</th>
                                        <th>Email</th>
                                        <th>Ajouté par</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($comptes as $compte)
                                        <tr>
                                            <td>{{ $compte->prenom . ' ' . $compte->nom }}</td>
                                            <td>{{ $compte->email }}</td>
                                            @php
                                                if($compte->admin_id == auth()->guard('admin')->id())
                                                    $name = 'Vous';
                                                else
                                                    $name = $compte->admin->prenom . ' ' . $compte->admin->nom;
                                            @endphp
                                            <td>{{ $name }}</td>
                                            <td class="actions-cell">
                                                <a href="{{ route('show.update', ['id' => $compte->user_principale_id]) }}" class="btn-action btn-edit" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('account.det', ['id' => $compte->user_principale_id])}}" class="btn-action btn-view" title="Détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('compte.delete', ['id' => $compte->user_principale_id]) }}" method="post" class="delete-form" data-account-name="{{ $compte->prenom . ' ' . $compte->nom }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-action btn-delete delete-trigger" title="Supprimer">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty-row">
                                            <td colspan="4">
                                                <div class="empty-state">
                                                    <i class="fas fa-search"></i>
                                                    <p>Aucun compte ne correspond à votre recherche.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Sidebar (User Menu) -->
        <aside class="user-sidebar" id="userSidebar">
            <div class="user-sidebar-header">
                <h3>Menu Utilisateur</h3>
                <button class="close-sidebar-btn" id="closeUserSidebarBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="user-profile">
                <div class="profile-image">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-info">
                    <h3>Admin: {{ session('name') }}</h3>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="{{ route('admin.info') }}"><i class="fas fa-user-cog"></i> Paramètres du profil</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                    </li>
                </ul>
            </div>
        </aside>
        
        <!-- Overlay for mobile and sidebar backdrop -->
        <div class="overlay" id="overlay"></div>
        
        <!-- Delete Confirmation Modal -->
        <div class="modal" id="deleteModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Confirmation de suppression</h3>
                    <button class="close-modal-btn" id="closeModalBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="delete-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <p id="deleteMessage">Êtes-vous sûr de vouloir supprimer ce compte?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="cancelDeleteBtn">Annuler</button>
                    <button class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/comptes.js') }}"></script>
</body>
</html>
