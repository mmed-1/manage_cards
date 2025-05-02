<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Informations sur {{ $client->prenom . ' ' . $client->nom }}</h1>
        <a href="{{ route('display.clients')}}">Retour</a>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Numero de carte sim</th>
                    <th>Matriculation</th>
                    <th>marque</th>
                    <th>type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartes as $carte)
                    <tr>
                        <td>{{ $carte->num_carte_sim }}</td>
                        <td>{{ $carte->vehicule->matriculation}}</td>
                        <td>{{ $carte->vehicule->marque }}</td>
                        <td>{{ $carte->vehicule->type }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>