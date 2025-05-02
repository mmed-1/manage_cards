<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accès à l'application</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Accès à votre compte</h2>

    <p>Bonjour {{ $prenom }} {{ $nom }},</p>


    <p>Vous pouvez désormais accéder à l'application en utilisant le mot de passe suivant :</p>

    <p><strong>{{ $password }}</strong></p>


    <p>
        <a href="{{ route('auth.login') }}" style="display: inline-block; padding: 10px 20px; background-color: #38b6ff; color: white; text-decoration: none; border-radius: 5px;">
            Accéder à l'application
        </a>
    </p>

    <p>Pour des raisons de sécurité, nous vous recommandons de modifier votre mot de passe après votre première connexion.</p>

    <p>Merci,<br>L'équipe de support Too IT</p>
</body>
</html>
