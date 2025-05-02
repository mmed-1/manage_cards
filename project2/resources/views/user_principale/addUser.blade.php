<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Ajouter un utilisateur</h1>
        <a href="{{ route('compte.choice') }}">← Retour</a>
    </header>

    <main>
        <form action="{{ route('compte.addAcc') }}" method="post">
            @csrf
            <div>
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div>
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required />
            </div>

            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required />
            </div>

            <div>
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>

            <div>
                <label for="password2" class="form-label">Confirmer mot de passe</label>
                <input type="password" class="form-control" id="password2" name="password_confirmation" required />
            </div>

            <input type="submit" value="Ajouter utilisateur" />
            <input type="reset" value="Annuler" />
        </form>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if (session('create'))
            @switch(session('status'))
                @case('success')
                    <div style="color: green;">
                        ✅ Le compte a été créé avec succès et un e-mail a été envoyé.
                    </div>
                    @break

                @case('emailError')
                    <div style="color: orange;">
                        ⚠️ Le compte a été créé, mais l'e-mail n'a pas pu être envoyé. Veuillez réessayer plus tard.
                    </div>
                    @break

                @case('emailExist')
                    <div style="color: red;">
                        ❌ Cette adresse e-mail est déjà utilisée dans le système.
                    </div>
                    @break

                @case('unique')
                    <div style="color: red;">
                        ❌ Ce utilisateur existe déjà avec ce mail.
                    </div>
                    @break

                @case('failed')
                    <div style="color: red;">
                        ❌ Une erreur est survenue lors de la création du compte. Veuillez réessayer.
                    </div>
                    @break

                @default
                    <div style="color: gray;">
                        ℹ️ Statut inconnu.
                    </div>
            @endswitch
        @endif
    </main>
</body>
</html>