<!DOCTYPE html>
<html lang="en">
<x-head title="Home">
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Votre espace {{ session('name') }}</h1>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('admin.choice2') }}">gestions des comptes</a>
                </li>
                <li>
                    <a href="{{ route('admin.choice') }}">gestion des equipements</a>
                </li>
                <li>
                    <a href="{{ route('blr.admin') }}">consultation des cartes BLR</a>
                </li>
            </ul>
        </nav>
    </header>
    <section>
        <!-- if we have something for now we don't know nothing -->
    </section>
    <main>
        <!-- for main content -->
    </main>

    <x-footer>
        <!-- for now we don't know -->
    </x-footer>
</body>
</html>
