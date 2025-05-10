<!DOCTYPE html>
<html lang="en">
<head title="Ajout d'equipement">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/equi-add.css') }}">
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
                    <li>
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="has-submenu">
                        <div class="submenu-toggle">
                            <i class="fas fa-user"></i> 
                            <span>Gestion de Compte</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.addAcc')}}"><i class="fas fa-plus-circle"></i> Ajout Compte</a></li>
                            <li><a href="{{ route('compte.details') }}"><i class="fas fa-list"></i> Consulter Comptes</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu open">
                        <div class="submenu-toggle">
                            <i class="fas fa-server"></i> 
                            <span>Gestion des Equipements</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li class="active"><a href="{{ route('ajout') }}"><i class="fas fa-plus-circle"></i> Ajout Equipement</a></li>
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
                    <h1>Ajout d'equipement</h1>
                    <p>Ajouter un nouvel équipement au système</p>
                </div>
                <div class="top-actions">
                    <button id="userMenuToggle" class="user-menu-toggle">
                        <i class="fas fa-user-circle"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <div class="card form-card">
                    <div class="card-header">
                        <h2><i class="fas fa-server"></i> Informations de l'équipement</h2>
                    </div>
                    
                    <div class="card-body">
                        <!-- Status Messages -->
                        <div id="status-container">
                            @if ($errors->any())
                                <div class="status-message error animate-in">
                                    <div class="status-icon">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div class="status-content">
                                        <h3>Erreur</h3>
                                        <ul class="error-list">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            
                            @if (session('submited'))
                                @if (session('error'))
                                    <div class="status-message warning animate-in">
                                        <div class="status-icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="status-content">
                                            <h3>Attention!</h3>
                                            <p>Cet équipement est déjà enregistré</p>
                                        </div>
                                    </div>
                                @elseif (session('status') === 'success')
                                    <div class="status-message success animate-in">
                                        <div class="status-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="status-content">
                                            <h3>Succès!</h3>
                                            <p>L'équipement a été ajouté avec succès</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="status-message error animate-in">
                                        <div class="status-icon">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                        <div class="status-content">
                                            <h3>Erreur!</h3>
                                            <p>Il y a un problème</p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <form action="{{ route('addEquipement') }}" method="post" class="form">
                            @csrf
                            
                            <div class="form-group">
                                <label for="l0" class="form-label">nom d'équipement</label>
                                <div class="input-group">
                                    <span class="input-icon"><i class="fas fa-network-wired"></i></span>
                                    <input type="text" class="form-control" id="l0" name="name" autofocus required placeholder="Ex: Routeur1" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="l1" class="form-label">Adresse IP</label>
                                <div class="input-group">
                                    <span class="input-icon"><i class="fas fa-network-wired"></i></span>
                                    <input type="text" class="form-control" id="l1" name="ip_address" required placeholder="Ex: 192.168.1.1" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="l2" class="form-label">Nombre de ports</label>
                                <div class="input-group">
                                    <span class="input-icon"><i class="fas fa-plug"></i></span>
                                    <input type="number" class="form-control" id="l2" name="nombre_port" required placeholder="Ex: 24" min="1" />
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> Ajouter l'équipement
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Annuler
                                </button>
                            </div>
                        </form>
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

    <script src="{{ asset('js/equi-add.js') }}"></script>
</body>
</html>
