<?php session_start(); ?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Politique de confidentialité - Mon blog</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-icons-1.13.1/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="d-flex flex-column min-vh-100" style="background-color: #f4f7f6;">

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

        <main class="container my-5 flex-grow-1">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card shadow-sm border-0 p-4 bg-white rounded">

                        <h1 class="text-center mb-4" style="color: #333; font-weight: bold;">Politique de confidentialité.</h1>
                        <p class="text-muted text-center">Dernière mis en jour : <?php echo date('d/m/Y '); ?></p>

                        <hr class="my-4">

                        <p>
                            La présente politique de confidentialité définit et vous informe de la manière dont
                            <strong>Mon blog</strong> utilise et protège les informations que vous nous transmettez lorsque 
                            vous utilisez ce site.
                        </p>

                        <h3 class="mt-4 fw-bold" style="color: #ffa400;">1. Collecte de données</h3>

                        <p>
                            Nous collectons uniquement les données strictement nécessaires au bon fonctionnement
                            du blog. Cela inclut : 
                        </p>
                        <ul>
                            <li><strong>Lors de l'inscription / connexion :</strong>Votre nom, prénom, pseudo et mot de passe 
                            (qui est immédiatement haché et sécurisé en base de données).</li>
                            <li><strong>Lors de l'utilisation du formulaire de contact :</strong> Votre adresse e-mail et le
                            continu de votre message.</li>
                        </ul>

                        <h3 class="mt-4 fw-bold" style="color: #ffa400;">2. Utilisation des données</h3>
                        <p>
                            Les informations que nous recueillons sont utilisées exclusivements pour : 
                        </p>
                        <ul>
                            <li>Permettre l'accès à votre éspace ùmembre et la publications de vos articles.</li>
                            <li>Répondre à vos messages envoyésvie la page de contact.</li>
                            <li>Améliorer l'expérience utilisateur sur notre site.</li>
                        </ul>
                        
                        <h3 class="mt-4 fw-bold" style="color: #ffa400;">3. Sécurité et hachage des mots de passe</h3>
                        <p> La sécurité de vos données est notre priorité absolue. Vos mpots de passe ne sont jamis stockés en
                            texte clair : ils subissent un chiffrement de haut niveau grace à des algorithmes de hachage
                            robustes natifs à PHP (<code>password_hash</code>). Ainsi, personne, 
                            pas meme les administrateurs du site, ne peut lire le mot de passe.
                        </p>

                        <h3 class="mt-4 fw-bold" style="color: #ffa400;">Géstion des coockies</h3>
                        <p>
                            Notre site utilise des coockies techniques nécessaires à la navigation : 
                        </p>
                        <ul>
                            <li>Des cookies de session pour maintenir votre connexion active.</li>
                            <li>Un cookie facultatif <strong>"Remember me"</strong> (Rester connecté)
                                stocké de manière sécurisée si vous cochez la case lors de l'authentification.
                                Vous pouvez le supprimer à tout moment en vous déconnectant.
                            </li>
                        </ul>

                        <h3 class="mt-4 fw-bold" style="color: #ffa400;">5. Partage à des tiers</h3>
                        <p>Nous nous engageons à ne jamais vendre, louer, céder ou partager vos informations
                            personnelles à des entreprises tierces à des fins commerciales.
                        </p>

                        <div class="text-center mt-5">
                            <a href="index.php" class="btn text-light px-4 shadow-sm" style="background: #ffa400;">Rétour à l'acceuil</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </main>

        <script src="bootstrap/js/bootstrap.bundle.js" ></script>

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

    </body>

</html>