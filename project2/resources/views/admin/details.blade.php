<!DOCTYPE html>
<html lang="en">
<x-head title="Informations sur le Compte">
    <link rel="stylesheet" href="{{ asset('css/acc-details.css') }}">
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
                    <h1>Informations sur le Compte</h1>
                    <p>Détails du compte de {{ $compte->prenom . ' ' . $compte->nom }}</p>
                </div>
                <div class="top-actions">
                    <button id="userMenuToggle" class="user-menu-toggle">
                        <i class="fas fa-user-circle"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Users Card -->
                <div class="card" id="usersCard">
                    <div class="card-header">
                        <h2><i class="fas fa-users"></i> Utilisateurs</h2>
                        @if ($usersNumber != 0)
                            <span class="badge">{{ $usersNumber }}</span>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        @if ($usersNumber != 0)
                            <div class="search-container">
                                <input type="text" class="search-input" id="searchUsers" placeholder="Rechercher un utilisateur...">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                        @endif
                        
                        <div class="table-container">
                            <table id="usersTable">
                                <thead>
                                    <tr>
                                        <th data-sort="name">Nom complet <i class="fas fa-sort"></i></th>
                                        <th data-sort="email">Email <i class="fas fa-sort"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $user->prenom . ' ' . $user->nom }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty-message">
                                                <i class="fas fa-info-circle"></i> Pas d'utilisateurs pour le moment.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SIM Cards -->
                <div class="card" id="simCard">
                    <div class="card-header">
                        <h2><i class="fas fa-sim-card"></i> Cartes SIM</h2>
                        @if ($cartesNumber != 0)
                            <span class="badge">{{ $cartesNumber }}</span>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        @if ($cartesNumber != 0)
                            <div class="search-container">
                                <input type="text" class="search-input" id="searchSim" placeholder="Rechercher une carte SIM...">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                        @endif
                        
                        <div class="table-container">
                            <table id="simTable">
                                <thead>
                                    <tr>
                                        <th data-sort="number">Numéro de carte <i class="fas fa-sort"></i></th>
                                        <th data-sort="operator">Opérateur <i class="fas fa-sort"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cartesSim as $carte)
                                        <tr>
                                            <td>{{ $carte->num_carte_sim }}</td>
                                            <td>{{ $carte->operateur }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty-message">
                                                <i class="fas fa-info-circle"></i> Aucune carte SIM pour le moment.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- BLR Cards -->
                <div class="card" id="blrCard">
                    <div class="card-header">
                        <h2><i class="fas fa-broadcast-tower"></i> Cartes BLR</h2>
                        @if ($cartesBlrNumber != 0)
                            <span class="badge">{{ $cartesBlrNumber }}</span>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        @if ($cartesBlrNumber != 0)
                            <div class="search-container">
                                <input type="text" class="search-input" id="searchBlr" placeholder="Rechercher une carte BLR...">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                        @endif
                        
                        <div class="table-container">
                            <table id="blrTable">
                                <thead>
                                    <tr>
                                        <th data-sort="number">Numéro de carte <i class="fas fa-sort"></i></th>
                                        <th data-sort="operator">Opérateur <i class="fas fa-sort"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cartesBlr as $carte)
                                        <tr>
                                            <td>{{ $carte->num_carte }}</td>
                                            <td>{{ $carte->operateur }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty-message">
                                                <i class="fas fa-info-circle"></i> Aucune carte BLR pour le moment.
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
    </div>

    <script src="{{ asset('js/acc-details.js') }}"></script>
</body>
</html>
