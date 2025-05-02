<!DOCTYPE html>
<html lang="en">
<x-head title="Home | "> {{-- {{$role}} don't forget that--}}
    <link rel="stylesheet" href="">
</x-head>
<body>
    <header>
        <h1>Votre espace {{session('name')}}</h1>   {{-- user name variable tp personilaze --}}
        <nav>
            <ul>
            @if (session('guard') === 'user_principale')
                <li>
                    <a href="{{ route('compte.choice') }}">gestion des utilisateurs</a>
                </li>
                <li>
                    <a href="{{ route('choice.vehicule') }}">gestion des vehicules</a>
                </li>
            @endif
                <li>
                    <a href="{{ route('choice2') }}">gestion des clients</a>
                </li>
                <li>
                    <a href="{{ route('choice') }}">gestion des cartes</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- I don't know the data to put here -->
    </main>

    <x-footer></x-footer>
</body>
</html>