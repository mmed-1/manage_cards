<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Modifier la vehicule {{ $vehicule->matriculation }}</h1>
    </header>

    <main>
        <form action="{{ route('vehicule.update', ['id' => $vehicule->vehicule_id]) }}" method="post">
            @csrf
            <div>
                <label for="df">Marque</label>
                <input type="text" name="marque" id="df" autofocus required value="{{ $vehicule->marque }}" />
            </div>

            <div>
                <label for="dj">Matriculation</label>
                <input type="text" name="matriculation" id="dj" required value="{{ $vehicule->matriculation }}" />
            </div>

            <div>
                <label for="dm">Type</label>
                <input type="text" name="type" id="dm" required value="{{ $vehicule->type }}" />
            </div>

            <input type="submit" value="Modifier véhicules" />
        </form>
        @if (session('create'))
            @if (session('status') === 'unique')
                <div>
                    <span style="color: red;">
                        Ce matricule deja existe
                    </span>
                </div>
            @else
                <div>
                    <span style="color: red;">
                        Il y a un probleme
                    </span>
                </div>
            @endif
        @endif
    </main>
</body>
</html>