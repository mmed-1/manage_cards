<!DOCTYPE html>
<html lang="en">
<x-head title="Détails de la Carte BLR">
    <link rel="stylesheet" href="{{ asset('css/blr-details.css') }}">
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
                    <li class="has-submenu active">
                        <div class="submenu-toggle">
                            <i class="fas fa-sim-card"></i> 
                            <span>Cartes BLR</span>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        </div>
                        <ul class="submenu">
                            <li><a href="{{ route('admin-blr.add') }}"><i class="fas fa-plus-circle"></i> Ajout SIM BLR</a></li>
                            <li class="active"><a href="{{ route('details.blr') }}"><i class="fas fa-list"></i> Consulter Cartes BLR</a></li>
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
                    <h1>Détails de la Carte BLR</h1>
                    <p>Numéro de carte: {{ $numero }}</p>
                </div>
                <div class="top-actions">
                    <button id="userMenuToggle" class="user-menu-toggle">
                        <i class="fas fa-user-circle"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Recharges Card -->
                <div class="card" id="rechargesCard">
                    <div class="card-header">
                        <h2><i class="fas fa-history"></i> Historique des Recharges</h2>
                        @if ($count != 0)
                            <span class="badge">{{ $count }}</span>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        @if ($count != 0)
                            <div class="search-container">
                                <input type="text" class="search-input" id="searchRecharges" placeholder="Rechercher une recharge...">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                        @endif
                        
                        <div class="table-container">
                            <table id="rechargesTable">
                                <thead>
                                    <tr>
                                        <th data-sort="date">Date de recharge <i class="fas fa-sort"></i></th>
                                        <th data-sort="montant">Montant <i class="fas fa-sort"></i></th>
                                        <th data-sort="user">Rechargée par <i class="fas fa-sort"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recharges as $recharge)
                                        <tr>
                                            <td>{{ $recharge->date_recharge }}</td>
                                            <td>{{ $recharge->montant }}</td>
                                            @php
                                                if($recharge->user_principale_id) {
                                                    if(session('guard') != 'admin') {
                                                        if(auth()->guard('user_principale')->id() == $recharge->user_principale_id)
                                                            $name = 'Vous';
                                                        else
                                                            $name = $recharge->utlisater_principale->prenom . ' ' . $recharge->utlisater_principale->nom;
                                                    }
                                                } elseif($recharge->user_id) {
                                                    if(session('guard') != 'admin') {
                                                        if(auth()->guard('user')->id() == $recharge->user_id)
                                                            $name = 'Vous';
                                                        else
                                                            $name = $recharge->utilisateur->prenom . ' ' . $recharge->utilisateur->nom;
                                                    }
                                                } else $name = ' ';
                                            @endphp
                                            <td>{{ $name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="empty-message">
                                                <i class="fas fa-info-circle"></i> Aucune recharge effectuée pour le moment.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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

    <script src="{{ asset('js/blr-details.js') }}"></script>
    {{-- <script src="{{ asset('js/blr-det.js') }}"></script> --}}
</body>
</html>
