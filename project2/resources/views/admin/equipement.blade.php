<!DOCTYPE html>
<html lang="en">
<x-head title="Détails sur l'équipement">
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
                    <li class="active">
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="has-submenu">
                        <div class="submenu-toggle">
                            <i class="fas fa-user"></i> 
                            <span>Gestion de Compte</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.addAcc') }}"><i class="fas fa-plus-circle"></i>Ajout de Compte</a></li>
                            <li><a href="{{ route('compte.details') }}"><i class="fas fa-list"></i>Consulter les Comptes</a></li>
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
                    <h1>Détails sur l'équipement {{ $equipement->name }}</h1>
                    <p>Informations détaillées et cartes associées</p>
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
                        <h2><i class="fas fa-info-circle"></i> Informations sur l'équipement</h2>
                    </div>
                    
                    <div class="card-body">
                        <div class="equipment-info">
                            @if ($numbers != 0)
                                <div class="info-badge">
                                    <i class="fas fa-microchip"></i>
                                    <span>Cet équipement possède {{ $numbers }} carte{{ $numbers > 1 ? 's' : '' }}.</span>
                                </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="data-table" id="cardsTable">
                                <thead>
                                    <tr>
                                        <th>Numéro de port <i class="fas fa-sort"></i></th>
                                        <th>Numéro de carte <i class="fas fa-sort"></i></th>
                                        <th>Opérateur <i class="fas fa-sort"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cartes as $carte)
                                        <tr>
                                            <td>{{ $carte->num_port }}</td>
                                            <td>{{ $carte->num_carte }}</td>
                                            <td>{{ $carte->operateur }}</td>
                                        </tr>
                                    @empty
                                        <tr class="empty-row">
                                            <td colspan="3">
                                                <div class="empty-state">
                                                    <i class="fas fa-microchip"></i>
                                                    <p>Aucune carte n'est installée sur cet équipement.</p>
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
    </div>
    
    <script src="{{ asset('js/dashboard.js')}}"></script>
</body>
</html>
