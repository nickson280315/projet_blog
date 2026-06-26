<?php session_start(); ?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A propos de nous - Mon blog</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-icons-1.13.1/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="shadow-sm" style="background-color: #f4f7f6;">

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
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 p-4 bg-white rounded">

                        <h1 class="text-center mb-4" style="color: #333; font-weight: bold;">Qui sommes nous ?</h1>

                        <p class="lead text-center text-muted">
                            Bienvenue sur notre platforme de partage et d'expression.
                        </p>

                        <hr class="my-4">

                        <p>
                            Ce bloc à été créé avec une idée simple : permettre à chacun des informer,
                            d'apprendre et de partager des connaissances de manière fluide et agréable.
                            Que vous soyez passionné de technologie, de design ou de style de vie, vous
                            trouverez ici des articles avec soin.
                        </p>

                        <p>Développé entièrement à la main en PHP, HTML, CSS et Bootstrap, ce site est le fruit 
                            d'un travaille d'apprentissage et de passion pour le développement web. Il intègre 
                            un éspace membre sécurisé, une interface de publication d'articles intuitif et un design
                            moderne adapté à tous les écrans.
                        </p>

                        <p>
                            Derrière ce projet se cache une volonté d'offrir un éspace d'échange propre et fonctionnel.
                            Nous travaillons constamment à l'amélioration de la platforme pour ajouter des nouvelles
                            fonctionnalités (commentaires, likes, gestion avancée du profil).
                        </p>

                        <div class="text-center mt-2 mb-1">
                            <a href="login_articles.php" class="btn btn-warning text-white fw-bold px-4 shadow-sm">
                                Retourner aux articles
                            </a>
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