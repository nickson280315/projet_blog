<?php include("db_connect.php");

    // Réquète pour insérer les données dans la table contact.

    if (isset($_POST['submit_contact'])){
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        $sujet = $_POST['sujet'];
        $message = $_POST['message'];

        if (TRUE){
            $req = $connect->prepare("INSERT INTO contact(nom, email, sujet, message) VALUES (?, ?, ?, ?)");
            $row = $req->execute([$nom, $mail, $sujet, $message]);
            if ($row){
                $message = "Message envoyé avec succès.";
            }
            else {
                $erreur = "Eléments entrés invalide";
            }
        }
    }

    // Réquète pour récuperer les données dans la table adresse.

    $req = $connect->prepare("SELECT * FROM adresse");
    $req->execute();
    $adresse = $req->fetchAll();

?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-icons-1.13.1/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body  style="background-color: #e5e5e5ff;">

        <header>
            <nav class="navbar navbar-expand-lg pt-0 pb-0">
                <div class="masthead" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)), url('images/bram-naus-n8Qb1ZAkK88-unsplash.jpg');">
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
                                    <h6 class="col-lg-6 me-5 ps-0" style="color: rgb(226, 225, 225);">Nickson code</h6>
                                </div>
                            </div> 

                            <div class="col-lg-4 ms-auto w-25 pe-3 pt-2">
                                <button class="navbar-toggler toggle mt-3 mb-0 pb-0 border dorder-dark bg-light opacity-75" type="button" data-bs-toggle="collapse" data-bs-target="#toggle">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse justify-content-end col-lg-4" id="toggle">
                                <div>
                                    <ul class="navbar-nav align-items-end me-4">
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php">Acceuil<i class="bi bi-house-fill ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="blog.php">Blog<i class="bi bi-journal-text ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="login_connexion.php">Se connecter<i class="bi bi-person-plus-fill ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="contact.php">Contact<i class="bi bi-envelope-fill ps-1"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="container">
                            <h1 class="mt-2 mt-5 pt-4 text-center text-info fs-1 fw-3">Nous contacter</h1>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        
        <div class="contact-info py-5 my-5" id="contact-info">
            <div class="container">
                <div class="contact-wrapper row">
                    <?php foreach ($adresse as $adr){ ?>
                    <div class="c-info col-lg-4">
                        <div class="info-item d-flex">
                            <div class="info-icon pe-3 pt-2">
                                <i class="bi bi-house-fill"></i>
                            </div>
                            <div class="info-text">
                                <h6 class="text-start mb-0" style="font-weight: 500;"><?php echo htmlspecialchars($adr['adress']); ?></h6>
                                <p class="text-secondary"><?php echo htmlspecialchars($adr['details']); ?></p>
                            </div>
                        </div>

                        <div class="info-item d-flex">
                            <div class="info-icon pe-3 pt-2">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <div class="info-text">
                                <h6 class="text-start mb-0" style="font-weight: 500;"><?php echo htmlspecialchars($adr['telephone']); ?></h6>
                                <p class="text-secondary"><?php echo htmlspecialchars($adr['horaire']); ?></p>
                            </div>
                        </div>

                        <div class="info-item d-flex ">
                            <div class="info-icon pe-3 pt-2">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="info-text">
                                <h6 class="text-start mb-0" style="font-weight: 500;"><?php echo htmlspecialchars($adr['email']); ?>m</h6>
                                <p class="text-secondary text-start">Ecrivez-nous à tous moment</p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <form action="contact.php" method="post" class="col-lg-8">
                        <div class="c-form px-0 mx-0 mt-3 mt-lg-0">
                            <div class="row row-cols-6 justify-content-center w-100 px-0 mx-0">
                                <div class="col w-50">
                                    <div class="mb-3">
                                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom" aria-describedby="helpId"/>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" name="mail" id="email" class="form-control" placeholder="Email" aria-describedby="helpId"/>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="sujet" id="sujet" class="form-control" placeholder="Sujet" aria-describedby="helpId"/>
                                    </div>
                                </div>
                                <div class="col w-50">
                                    <div class="mb-3">
                                        <textarea class="form-control" name="message" id="message" placeholder="Votre message"></textarea>
                                    </div>
                                </div>
                                <button type="submit" name="submit_contact" class="btn btnn text-nowrap d-inline-flex align-items-center w-25 ps-2 ps-lg-5">Envoyer<i class="bi bi-send-arrow-up-fill ps-1 ps-lg-2 pe-4 p-lg-0 pe-lg-0"></i></button>
                                
                            </div>
                        </div>
                    </form>
                </div>
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
        
        <script src="bootstrap/js/bootstrap.bundle.js" ></script>
        
    </body>

</html>