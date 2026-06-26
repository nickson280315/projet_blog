<?php 

    include("db_connect.php");
    session_start();

    $erreur = "";
    $succes = "";
    $user_valide = false;

    if (isset($_POST['verifier_identite'])){
        $nom = htmlspecialchars($_POST['nom']);
        $pseudo = htmlspecialchars($_POST['pseudo']);

        $req = $connect->prepare("SELECT * FROM utilisateurs WHERE nom_ut = ? AND prenom = ?");
        $req->execute([$nom, $pseudo]);
        $user = $req->fetch();

        if ($user) {
            $_SESSION['recup_id_ut'] = $user['Id_ut'];
            $user_valide = true;
        }
        else{
            $erreur = "Le nom ou le pseudo est incorrect.";
        }
    }

    if (isset($_POST['changer_password'])){
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password === $confirm_password){
            if (isset($_SESSION['recup_id_ut'])){
                $id_ut = $_SESSION['recup_id_ut'];
                $password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

                if (strlen($password_hashed < 8)){
                    $erreur = "Le mot de passe doit conténir plus ou moin 8 caractères";
                }
                else{
                    $update = $connect->prepare("UPDATE utilisateurs SET password = ? WHERE Id_ut = ?");
                    $update->execute([$password_hashed, $id_ut]);
                    unset($_SESSION['recup_id_ut']);
                    $succes = "Mot de passe modifié avec succès ! <a href='login_connexion.php' class='text-warning'>Se connecter</a>";
                }
            }
            else{
                $erreur = "Une erreur est survenue. Veuillez recommencer.";
            }
        }
        else{
            $user_valide = true;
            $erreur = "Les mots de passe ne conrespondent pas.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Récupération de mot de passe</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-icons-1.13.1/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body style="background: url('images/allen-y-OTNBYwfirV0-unsplash.jpg') no-repeat center center fixed; background-size: cover; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0;">
        <div class="wrapperr">
            <h2>Récupération</h2>

            <?php if (!empty($erreur)) echo "<p style='color: #ff4d4d; text-align: center;'>$erreur</p>"; ?>
            <?php if (!empty($succes)) echo "<p style='color: #2ecc71; text-align: center;'>$succes</p>"; ?>

            <?php if ($user_valide == false && empty($succes)): ?>

                <form action="" method="post">
                    <div class="input-boxx">
                        <input type="text" name="nom" placeholder="Entrer votre nom" class="form" require>
                    </div>
                    <div class="input-boxx">
                        <input type="text" name="pseudo" placeholder="Entrer votre pseudo" class="form" require>
                    </div>
                    <button type="submit" name="verifier_identite" class="btn">Vérifier mon identité</button>

                    <div class="register-link" style="text-align: center; margin-top: 20px;">
                        <p><a href="login_connexion.php" class="ms-1">Retour à la connection</a></p>
                    </div>

                </form>

            <?php elseif ($user_valide == true && empty($succes)): ?>

                <form action="" method="post">
                    <p style="color: #ccc; text-align: center; font-size: 14px;">Identité confirmée. Saisissez votre nouveau mot de passe.</p>
                    
                    <div class="input-boxx" style="position: relative;">
                        <input type="password" name="new_password" id="new_password" placeholder="Nouveau password" class="form" required>
                        <i class="bi bi-eye-slash" id="toggleNewPassword" onclick="togglePasswordInput('new_password', 'toggleNewPassword')" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 20px; color: #ccc;"></i>
                    </div>

                    <div class="input-boxx" style="position: relative;">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmer password" class="form" required>
                        <i class="bi bi-eye-slash" id="toggleConfirmPassword" onclick="togglePasswordInput('confirm_password', 'toggleConfirmPassword')" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 20px; color: #ccc;"></i>
                    </div>

                    <button type="submit" name="changer_password" class="btn">Mettre à jour le mot de passe</button>

                </form>

            <?php endif; ?>

        </div>

        <script>
            function togglePasswordInput(inputId, iconId){
                var champ = document.getElementById(inputId);
                var icone = document.getElementById(iconId);

                if (champ.type === "password"){
                    champ.type = "text";
                    icone.classList.remove("bi-eye-slash");
                    icone.classList.add("bi-eye");
                }
                else{
                    champ.type = "password";
                    icone.classList.remove("bi-eye");
                    icone.classList.add("bi-eye-slash");
                }
            }
        </script>
    </body>
    
</html>