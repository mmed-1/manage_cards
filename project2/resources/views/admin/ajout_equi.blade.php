<!DOCTYPE html>
<html lang="en">
<x-head title="">
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <head>
        <h1>Ajout d'equipement</h1>
        <a href="{{route('admin.choice')}}">Retour</a>
    </head>
    <main>
        <form action="{{route('addEquipement')}}" method="post">
            @csrf
            <label for="l1">Adresse IP:</label>
            <input type="text" name="ip_address" id="l1" autofocus required /> <br>
    
            <label for="l2">Nombre de ports:</label>
            <input type="text" name="nombre_port" id="l2" required /> <br>
    
            <input type="submit" value="Ajouter l'equipement" />
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
        @if (session('submited'))
            @if (session('error'))
                <span style="color: red;">cette equipement deja enregistre</span>
            @elseif (session('status') === 'success')
                <span style="color: green;">L'equipement est bien Ajoute</span>
            @else
                <span style="color: red;">Il y a un probleme</span>
            @endif
        @endif
    </main>
    <x-footer></x-footer>
</body>
</html>