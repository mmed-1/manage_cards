<!DOCTYPE html>
<html lang="fr">
<x-head title="Liste des equipement">
    <link rel="stylesheet" href="{{ asset('css/equi-view.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
                    <li class="has-submenu">
                        <button class="submenu-toggle">
                            <i class="fas fa-user"></i> 
                            <span>Gestion de Compte</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </button>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.addAcc')}}"><i class="fas fa-plus-circle"></i> Ajout Compte</a></li>
                            <li><a href="{{ route('compte.details') }}"><i class="fas fa-list"></i> Consulter Comptes</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu open">
                        <button class="submenu-toggle">
                            <i class="fas fa-server"></i> 
                            <span>Gestion des Equipements</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </button>
                        <ul class="submenu">
                            <li><a href="{{ route('ajout') }}"><i class="fas fa-plus-circle"></i> Ajout Equipement</a></li>
                            <li class="active"><a href="{{ route('consultation') }}"><i class="fas fa-list"></i> Consulter Equipement</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <button class="submenu-toggle">
                            <i class="fas fa-sim-card"></i> 
                            <span>Cartes BLR</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </button>
                        <ul class="submenu">
                            <li><a href="{{ route('admin-blr.add') }}"><i class="fas fa-plus-circle"></i> Ajout SIM BLR</a></li>
                            <li><a href="{{ route('details.blr') }}"><i class="fas fa-list"></i> Consulter Cartes BLR</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main>
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="mobile-toggle" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="page-title">
                    <h1>Liste des équipements</h1>
                    <p>Gestion et consultation des équipements</p>
                </div>
                <div class="top-actions">
                    <button id="userMenuToggle" class="user-menu-toggle">
                        <i class="fas fa-user-circle"></i>
                    </button>
                </div>
            </div>

            <!-- Status Messages -->
            @if (session('submited'))
                @if (session('status') === 'success')
                    <div class="status-message success animate-in">
                        <div class="status-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="status-content">
                            <h3>Succès!</h3>
                            <p>L'équipement a été modifié avec succès.</p>
                        </div>
                    </div>
                @else
                    <div class="status-message error animate-in">
                        <div class="status-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="status-content">
                            <h3>Erreur!</h3>
                            <p>Une erreur s'est produite lors de la modification de l'équipement.</p>
                        </div>
                    </div>
                @endif
            @endif

            @if (session('error'))
                <div class="status-message error animate-in">
                    <div class="status-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="status-content">
                        <h3>Erreur!</h3>
                        <p>Une erreur s'est produite. Veuillez réessayer.</p>
                    </div>
                </div>
            @endif

            <!-- Search Box -->
            <div class="search-container">
                <input type="text" id="searchEquipment" class="form-control" placeholder="Rechercher un équipement...">
                <i class="fas fa-search search-icon"></i>
            </div>

            <!-- Table Container -->
            <div class="table-container">
                <div class="table-header">
                    <h2><i class="fas fa-server"></i> Liste des équipements</h2>
                    {{-- <div class="table-actions">
                        <a href="{{ route('ajout') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajouter un équipement
                        </a>
                    </div> --}}
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>nom d'équipement</th>
                            <th>Adresse IP</th>
                            <th>Nombre de ports</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipements as $equipement)
                            <tr>
                                <td>{{ $equipement->name }}</td>
                                <td>{{ $equipement->ip_address }}</td>
                                <td>{{ $equipement->nombre_port }}</td>
                                <td>
                                    <a href="{{ route('formEqui', ['id' => $equipement->equipement_id]) }}" class="action-btn edit-btn" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('eq.det', ['id' => $equipement->equipement_id]) }}" class="action-btn view-btn" title="Détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('deleteEqui', ['id' => $equipement->equipement_id])}}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn delete-btn" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="empty-state">
                                        <i class="fas fa-server"></i>
                                        <p>Aucun équipement pour le moment</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
        
        <!-- Include Delete Modal Component -->
        @include('components.delete-modal')
    </div>

    <script src="{{ asset('js/equi-view.js') }}"></script>
</body>
</html>