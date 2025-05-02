<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe mis à jour</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Mot de passe modifié avec succès</h2>

    <p>Bonjour {{ $prenom }} {{ $nom }},</p>

    <p>Nous vous informons que le mot de passe associé à votre compte a été modifié avec succès.</p>

    <p>Votre Nouvelle password est : <strong>{{ $password }}</strong></p>

    

    <p>
        <a href="{{ route('auth.login') }}" style="display: inline-block; padding: 10px 20px; background-color: #38b6ff; color: white; text-decoration: none; border-radius: 5px;">
            Se connecter à mon compte
        </a>
    </p>

    <p>Merci pour votre confiance,<br>
        L’équipe de support Too IT</p>
</body>
</html>
