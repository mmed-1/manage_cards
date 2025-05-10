<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
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
                    <h1>Tableau de Bord</h1>
                    <p>Bienvenue dans votre panneau d'administration</p>
                </div>
                <div class="top-actions">
                    <button id="userMenuToggle" class="user-menu-toggle">
                        <i class="fas fa-user-circle"></i>
                    </button>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Comptes</h3>
                        <div class="stat-value">{{ $data['countAcc'] }}</div>
                        <div class="stat-trend positive">nombre de comptes</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Véhicules</h3>
                        <div class="stat-value">{{ $data['countVehi'] }}</div>
                        <div class="stat-trend positive">nombre de véhicules</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>SIMs</h3>
                        <div class="stat-value">{{ $data['countSim'] }}</div>
                        <div class="stat-trend positive">nombre de carte SIMs</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-sim-card"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>BLRs</h3>
                        <div class="stat-value">{{ $data['numOfBlr'] }}</div>
                        <div class="stat-trend positive">nombre de cartes BLRs</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                </div>
            </div>

            <!-- Equipment Cards Section -->
            <section class="equipment-section">
                <div class="section-header">
                    @if (!$data['ports']->isEmpty())
                        <h2>Équipements et Cartes</h2>
                    @endif
                </div>
                <div class="equipment-cards">
                    @foreach($data['ports'] as $port)
                    <div class="equipment-card">
                        <div class="equipment-header">
                            <h3>{{ $port->name }}</h3>
                            <div class="equipment-icon">
                                <i class="fas fa-server"></i>
                            </div>
                        </div>
                        <div class="equipment-stats">
                            <div class="card-count">
                                <span class="count-value">{{ $port->total_cards }}/{{$port->nombre_port}}</span>
                                <span class="count-label">Cartes</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </main>

        <!-- Right Sidebar (User Menu) - Simplified as requested -->
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
                        <a href="{{ route('admin.info') }}"><i class="fas fa-user-cog"></i> Info de profil</a>
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

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
