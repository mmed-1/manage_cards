<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<x-head>
    <link rel="stylesheet" href="">
    <style>
        .header {
            background-color: #f8f9fa;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .back-button {
            background-color: #6c757d;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .back-button:hover {
            background-color: #5a6268;
        }
        
        .options-list {
            list-style: none;
            padding: 2rem;
            max-width: 600px;
            margin: 2rem auto;
        }
        
        .options-list li {
            margin: 1rem 0;
            padding: 1rem;
            background-color: #f1f1f1;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        
        .options-list li:hover {
            transform: translateX(10px);
        }
        
        .options-list a {
            text-decoration: none;
            color: #212529;
            font-size: 1.1rem;
            display: block;
        }
    </style>
</x-head>
<body>
    <header class="header">
        <h2>Gestion des utilisateurs</h2>
        <a href="{{ route('home') }}" class="back-button">
            ← Retour
        </a>
    </header>

    <main>
        <h1 style="text-align: center; margin-top: 2rem;">Sélectionnez une option</h1>
        <ul class="options-list">
            <li>
                <a href="{{ route('compte.userAjout') }}">
                    Ajouter un utilisateur
                </a>
            </li>
            <li>
                <a href="{{ route('users.details') }}">
                    Consulter les utilisateurs
                </a>
            </li>
        </ul>
    </main>
    <x-footer></x-footer>
</body>
</html>