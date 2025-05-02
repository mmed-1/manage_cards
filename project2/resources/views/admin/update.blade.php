<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Modifier votre equipement</h1>
        <a href="{{route('consultation')}}">Back</a>
    </header>

    <main>
        <form action="{{route('updateEquipement', ['id' => $equipement->equipement_id])}}" method="post">
            @csrf
            <label for="l1">Adresse IP:</label>
            <input type="text" name="ipAddress" id="l1" autofocus value="{{$equipement->ip_address}}" required /> <br>
    
            <label for="l2">Nombre de ports:</label>
            <input type="text" name="nbPorts" id="l2" value="{{$equipement->nombre_port}}" required /> <br>
    
            <input type="submit" value="Modifier l'equipement" />
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
    </main>
    <x-footer></x-footer>
    </main>
</body>
</html>