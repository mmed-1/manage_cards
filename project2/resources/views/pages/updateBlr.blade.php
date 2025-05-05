<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <main>
        <form action="{{ route('blr.update', ['id' => $carte->carte_blr_id]) }}" method="post">
            @csrf
            <h1>Modifier une carte BLR</h1>

            <div>
                <label for="l1">Numero de la carte:</label>
                <input type="text" name="num_carte" id="l1" required autofocus value="{{ $carte->num_carte }}"/>
            </div>

            <div>
                <label for="l4">Operateur:</label>
                <input type="text" name="operateur" id="l4" required value="{{ $carte->operateur }}"/>
            </div>

            <input type="submit" value="Modifier la carte" />
        </form>

        @if (session('update'))
            @if (session('status') === 'unique')
                <div>
                    <span style="color: red; padding: 10px;">
                        Ce numero est deja utilise
                    </span>
                </div>
            @else
                <div>
                    <span style="color: red; padding: 10px;">
                        Il y a un probleme
                    </span>
                </div>
            @endif
        @endif
    </main>
</body>
</html>