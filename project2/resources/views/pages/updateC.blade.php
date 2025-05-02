<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Modifier le client</h1>
    </header>
    <main>
        <form action="{{route('client.update', ['id' => $client->client_id])}}" method="post">
            @csrf
            <label for="x">Nom:</label>
            <input type="text" name="nom" id="x" required autofocus value="{{$client->nom}}"/> <br>

            <label for="y">Prenom:</label>
            <input type="text" name="prenom" id="y" required value="{{$client->prenom}}"/> <br>

            <label for="z">Email:</label>
            <input type="text" name="email" id="z" required value="{{$client->email}}"/> <br>

            <input type="submit" value="Modifier client">
            <button type="submit" name="reset" value="Annuler">Annuler</button>
        </form>
        @if ($errors->any())
            <ul>
                @foreach ($errors as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
        @if (session('update'))
            @if (session('error') === 'email')
                <span style="color: red; margin: 7px;">
                    L'email deja enregistre dans notre systeme
                </span>
            @else
                <span style="color: red; margin: 7px;">
                    Il y a un probleme
                </span>
            @endif
        @endif
    </main>
</body>
</html>