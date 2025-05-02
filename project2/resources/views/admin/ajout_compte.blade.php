<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <header>
        <h1>Ajouter un compte</h1>
        <a href="{{ route('admin.choice2')}}">← Retour</a>
    </header>
    <main>
        <form action="{{ route('compte.add' )}}" method="post">
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

            <input type="submit" value="Ajouter compte">
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
                    <div>
                        <span style="color: green;">
                            Le compte a été créé avec succès. <br> Un email a été envoyé
                        </span>
                    </div>
                    @break
                @case('unique')
                    <div>
                        <span style="color: red;">
                            L'adresse email est deja enregistre dans notre systeme
                        </span>
                    </div>
                @break
                    @case('failed')
                        <div>
                            <span style="color: red;">
                                Il y a un probleme
                            </span>
                        </div>
                    @break
                @default
                    <div>
                        <span style="color: red;">
                            Une probleme et serrevient
                        </span>
                    </div>
            @endswitch    
        @endif
    </main>

    <x-footer></x-footer>
</body>
</html>