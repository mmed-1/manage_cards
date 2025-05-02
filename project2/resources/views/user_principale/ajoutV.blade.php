<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Ajouter une véhicule</h1>
        <a href="{{ route('choice.vehicule')}}">← Retour</a>
    </header>

    <main>
        <form action="{{ route('vehicule.add') }}" method="post">
            @csrf
            <div>
                <label for="df">Marque</label>
                <input type="text" name="marque" id="df" autofocus required />
            </div>

            <div>
                <label for="dj">Matriculation</label>
                <input type="text" name="matriculation" id="dj" required />
            </div>

            <div>
                <label for="dm">Type</label>
                <input type="text" name="type" id="dm" required />
            </div>

            <input type="submit" value="Ajouter véhicules" />
            <input type="reset" value="Annuler" />
        </form>
        @if (session('create'))
            @if (session('status') === 'success')
                <div>
                    <span style="color: green;">Véhicule est bien ajouté</span>
                </div>
            @elseif (session('status') === 'unique')
                <div>
                    <span style="color: red;">
                        Ce matricule est deja enregistre
                    </span>
                </div>
            @else
                <div>
                    <span style="color: red;">
                        Il y a un problenme
                    </span>
                </div>
            @endif
        @endif
    </main>
</body>
</html>