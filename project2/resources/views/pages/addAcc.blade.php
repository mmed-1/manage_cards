<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Creer un client</h1>
        <a href="{{route('choice')}}">Retour</a>
    </header>

    <main>
        <form action="{{route('ajout.client')}}" method="post">
            @csrf
            <label for="x">Nom:</label>
            <input type="text" name="nom" id="x" required autofocus /> <br>

            <label for="y">Prenom:</label>
            <input type="text" name="prenom" id="y" required /> <br>

            <label for="z">Email:</label>
            <input type="text" name="email" id="z" required /> <br>

            <input type="submit" value="Ajouter client">
            <input type="reset" value="Annuler" />
        </form>
        
        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('creer'))
            @if (session('error'))
                <span style="color: red;">
                    cette email existe deja dans notre system 
                </span>
            @elseif(session('status') === 'success')
                <span style="color: green;">
                    Le client est bien enregistre
                </span>
            @else
                <span style="color: red;">
                    Il y a un probleme
                </span>
            @endif
        @endif
    </main>
</body>
</html>