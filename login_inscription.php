<?php include("db_connect.php"); 

    // Réquète pour insérer les données dans la table utilisateurs.

    if (isset($_POST["submit"])){
        $name = htmlspecialchars(trim($_POST["name"]));
        $pseudo = htmlspecialchars(trim($_POST["pseudo"]));
        $mail = htmlspecialchars(trim($_POST["mail"]));
        $password = $_POST["password"];
        $pass_hach = password_hash($password, PASSWORD_BCRYPT);
        $photo = isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';
        $target_dir = "images/";
        $target_file = $target_dir . basename($photo);
        $desc = htmlspecialchars(trim($_POST["desc"]));
        $role = htmlspecialchars("administrateur");

        if ($name && $pseudo && $mail && $password && $desc){
            if (strlen($name) <= 4){
                $erreur = "Le nom de l'utilisateur est trop court.";
            }
            elseif (strlen($pseudo) <= 4){
                $erreur = "Le pseudo de l'utilisateur est trop court.";
            }
            elseif (strlen($password) < 8){
                $erreur = "Le mot de passe doit contenir plus au moin 8 caractères.";
            }
            else{
                $req = $connect->prepare("INSERT INTO utilisateurs(nom_ut, prenom, email, 
                password, photo, description_ut, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $req->execute([$name, $pseudo, $mail, $pass_hach, $photo, $desc, $role]);
                if ($req){
                    if (isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name'] != ''){
                        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
                    }
                    header("Location: login_connexion.php?success=1#message-succes");
                    $message = "Utilisateurs ajouter avec succès.";
                }
                else{
                    $erreur = "Elément entrez invalide";
                }
            }
        }
        else{
            $erreur = "Veuillez remplir tous les champs";
        }
    }

?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-icons-1.13.1/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <header>
            <nav class="navbar navbar-expand-lg pt-0 pb-2" style="background-color: #eee;">
                
                    <div class="container">

                        <div class="row">
                            
                            <div class="col-lg-4 mt-3 me-5" style="width: 30%;">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-2 log">
                                        <a class="navbar-brand" href="aPropos.php">
                                            <img 
                                                src="images/logo.png" 
                                                alt="logo"
                                                class="img-fluid w-25 w-md-50 rounded-circle"
                                            >
                                        </a>
                                    </div>
                                    <h6 class="col-lg-6 me-5 ps-0" style="color: rgb(100, 100, 100);">Nickson code</h6>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 ms-auto w-25 pe-3 pt-2">
                                <button class="navbar-toggler toggle mt-3 mb-0 pb-0" type="button" data-bs-toggle="collapse" data-bs-target="#toggle">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse justify-content-end col-lg-4" id="toggle">
                                <div>
                                    <ul class="navbar-nav align-items-end me-4">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" href="index.php">Acceuil<i class="bi bi-house-fill ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" href="blog.php">Blog<i class="bi bi-journal-text ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" href="login_connexion.php">Se connecter<i class="bi bi-person-plus-fill ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" href="contact.php">Contact<i class="bi bi-envelope-fill ps-1"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                
            </nav>
        </header>

        <div class="login">

            <div class="wrapperr">
                <form action="login_inscription.php" method="POST" enctype="multipart/form-data">
                    <h1>Créer compte</h1>
                    <div class="input-boxx">
                        <input type="text" id="nom" name="name" placeholder="Entrez nom" class="form" required><i class="bi bi-person-fill"></i>
                    </div>
                    <div class="input-boxx">
                        <input type="text" id="pseudo" name="pseudo" placeholder="Entrez pseudo" class="form" required><i class="bi bi-person-vcard"></i>
                    </div>
                    <div class="input-boxx">
                        <input type="email" id="mail" name="mail" placeholder="Entrez e-mail" class="form" required><i class="bi bi-envelope-fill"></i>
                    </div>
                    <div class="input-boxx" style="position: relative;">
                        <input type="password" id="password" name="password" placeholder="Entrez password" class="form" required>
                        <i class="bi bi-eye-slash-fill" id="togglePassword" onclick="toggleMonPassword()" style="position: absolute; right: 20px;
                         top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 20px; color: #ccc;"></i>
                    </div>
                    <div class="input-boxx">
                        <input type="file" id="photo" name="photo" accept="image/*" class="form" required><i class="bi bi-image"></i>
                    </div>
                    <div class="input-boxx">
                        <input type="text" id="description" name="desc" placeholder="Ex: Développeur front-end" class="form" required><i class="bi bi-image"></i>
                    </div>

                    <button type="submit" name="submit" class="btn">S'inscrire</button>

                    <div class="register-link"><p>Avez-vous de compe?<a href="login_connexion.php" class="ms-2" style="color: #ffa400;">Se connecter</a></p></div>
                
                </form>

                <?php if (isset($erreur)){ ?>
                    <div class="alert alert-danger alert-dismissible fade fadee show ms-auto me-auto mt-3" role="alert" id="message-succes">
                        <i class="bi bi-exclamation-octagon-fill"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"aria-label="Close"></button>
                        <strong>Erreur !</strong> <?php echo $erreur; ?>
                    </div>
                    
                    <script>
                        window.history.replaceState({}, document.title, window.location.pathname);
                        document.getElementById('message-succes').scrollIntoView({behavior: 'smooth', block: 'center'});
                    </script>   
                <?php } ?>

                <?php if(isset($_GET['success']) && $_GET['success'] == 1){?>
                    <div class="alert alert-success alert-dismissible fadee show ms-auto me-auto mt-3" role="alert" id="message-succes">
                    <i class="bi bi-check-circle-fill"></i>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>
                        <strong>Succès !</strong><?php echo $message; ?>
                    </div>
                    
                    <script>
                        window.history.replaceState({}, document.title, window.location.pathname);
                        document.getElementById('message-succes').scrollIntoView({behavior: 'smooth', block: 'center'});
                    </script>
                <?php } ?>

                <script>

                    if (window.location.search.includes('success')){
                        window.history.replaceState({}, 
                        document.title, window.location.pathname);
                    }

                    setTimeout(function() {
                        const alerts = document.querySelectorAll('.alert');

                        alerts.forEach(function(alert) {
                            let bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        });
                    }, 5000);

                </script>

            </div>
            
        </div>

        <footer class="footer pt-4 mt-2" id="footer">
            <div class="row footer-blocks">
                <div class="col-lg-4 col-md-4 footer-block f-links">
                    <ul>
                        <li><a href="aPropos.php">A propos de nous</a></li>
                        <li><a href="contact.php" class="mt-3">Nous écrire</a></li>
                        <li><a href="confidentialite.php" class="mt-3">Politique de confidentialité</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-4 footer-block s-links">
                    <ul class="">
                        <li><a href="#"><i class="bi bi-facebook ms-4"></i></a></li>
                        <li><a href="#"><i class="bi bi-twitter ms-4"></i></a></li>
                        <li><a href="#"><i class="bi bi-youtube ms-4"></i></a></li>
                        <li><a href="#"><i class="bi bi-instagram ms-4"></i></a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-4 copyright text-center" id="copyright">
                    &copy; | Nickson code <script>document.write(new Date().getFullYear());</script> All rights reserved
                </div>
                
            </div>
        </footer>

        <script>
            function toggleMonPassword(){
                const togglePassword = document.querySelector('#togglePassword');
                const passwordInput = document.querySelector('#password');

                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 
                    'password';
                    passwordInput.setAttribute('type', type);
                    if (type === 'text'){
                        this.classList.remove('bi-eye-slash-fill');
                        this.classList.add('bi-eye-fill');
                    }
                    else{
                        this.classList.remove('bi-eye-fill');
                        this.classList.add('bi-eye-slash-fill');
                    }
                })
            }
        </script>

        <script src="bootstrap/js/bootstrap.bundle.js" ></script>

    </body>

</html>