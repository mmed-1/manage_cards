<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>detaille de vehicule {{ $matricule }}</h1>
    </header>
    <main>
        <div>
            <p>Cette vehicule a la carte sim de numero : {{ $card->num_carte_sim }}</p>
            <p>
                si tu veux plus d'infos cette carte sim 
                <a href="{{ route('sim.det', ['id' => $card->carte_sim_id]) }}">
                    cliquer ici
                </a>
            </p>
        </div>
    </main>
</body>
</html>