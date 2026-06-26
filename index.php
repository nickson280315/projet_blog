<?php include("db_connect.php");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Requète pour récupérer les données de la table articles.

    $req = $connect->query("SELECT * FROM article ORDER BY date_pub DESC LIMIT 3");
    $row = $req->fetchAll();

    // Requète pour récupérer les données de la table utilisateurs.

    $req = $connect->query("SELECT * FROM utilisateurs  WHERE role = 'administrateur' 
    ORDER BY Id_ut DESC LIMIT 4");
    $roww = $req->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap-icons-1.13.1/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

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
                                            class="img-fluid w-25 rounded-circle"
                                        >
                                    </a>
                                </div>
                                <h6 class="col-lg-6 me-5 ps-0" style="color: rgb(226, 225, 225);">Nickson code</h6>
                            </div>
                        </div> 

                        <div class="col-lg-4 ms-auto w-25 pe-3 pt-2">
                            <button class="navbar-togglerr navbar-toggler toggle mt-3 mb-0 pb-0 bg-light opacity-50 border border-dark" type="button" data-bs-toggle="collapse" data-bs-target="#toggle">
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
                                    <li class="nav-item">
                                        <a class="nav-link" href="login_connexion.php">Se connecter<i class="bi bi-person-plus-fill ps-1"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="contact.php">Contact<i class="bi bi-envelope ps-1"></i></a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="container">
                        <div class="justify-content-center mt-5">
                            <h1 class="mt-2 mb-5 text-center text-info fs-1 fw-3">Pratiquer et devenir meilleur</h1>
                            <p class="text-light text-center fs-5 fw-5" style="text-indent: 10%;">
                                Découvrez des articles passionnants écrits par une communauté de passionnés. Apprenez de nouvelles astuces chaque jour et partagez
                                 votre propre expérience avec le monde.
                            </p>
                            <div class="text-center">
                                <a href="blog.php"><button type="button" class="btnn btn btn-outline mb-5 mt-3 py-1 px-2">
                                    Découvrir le monde
                                </button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>

        <section class="card border-0">
            
            <div class="row mx-3 my-3 py-lg-5">

                <?php foreach ($row as $i) { ?>
                <div class="col-lg-4 border-bottom border-lg-bottom-0 border-lg-end border-dark py-3">
                    <h4 class="text-center" style="color: #ffa400"><?php echo htmlspecialchars($i["nom_art"]); ?></h4>
                    <p class="py-2"><?php $extr = strip_tags($i["description"]);
                                          echo strlen($extr) > 100 ? substr($extr, 0, 100) . "..." : $extr; ?>
                    </p>
                    <div class="text-center pb-1"><a href="single.php?id=<?php echo $i["Id_art"]; ?>"><button type="button" class="btn btn-outline btnn text-center">Voir plus<i class="bi bi-three-dots ps-2"></i></button></a></div> 
                </div>
                <?php } ?>

            </div>

        </section>

        <section class="mentors mb-4 py-3 " style="background-color: rgb(240, 240, 240)">

            <div class="mx-3 pt-4">
                <h2 class="pb-3 mb-2 align-content-center" style="color: #ffa400;">Personnel à votre disposition.</h2>
                <p>Rencontrez les développeur passionnés qui font vivre cette platforme. Notre équipe
                    de mentors est là pour vous guider, répondre à vos quéstions et vous aidez à surmonter 
                    vos blocages techniques.
                </p>
            </div>
            
            <div class="container pb-4">
                <div class="row row-cols-2 row-cols-lg-4 row-cols-md-2 g-4 pb-lg-5">
                    <?php foreach ($roww as $admi){ ?>
                    <div class="col">
                        <div class="rounded-4 border border-warning p-2">
                            <div class="avatar-wrapper my-3">
                                <a href="contact.php" class="text-decoration-none">
                            <img src="images/<?php echo htmlspecialchars($admi['photo']); ?>" alt="mentor" class="img-fluid rounded-circle h-100 w-100 object-fit-cover;" title="click pour contacter le personnel client"></a>                          
                            </div>
                            <a href="contact.php" class="text-decoration-none"><h5 class="pb-1" style="color: #ffa400; font-size: 1rem;"><?php echo $admi["prenom"]; ?></h5></a>
                            <p class=""><?php echo $admi["description_ut"]; ?></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

        </section>

        <section class="artricle">
            <div class="container">
                <h3 class="fw-1 pb-2" style="color: #ffa400;">Actualités et astuces tech</h3>
                <p class="pb-2">Réstez à jour avec les dernières tendances du web design et du développement back-end.
                </p>
            </div>
            <div class="article-img pb-md-5">
                <div class="row justify-content-center px-4">
                    <div class="col-6 col-lg-6">
                        <div>
                            <div class="article">
                                <img src="images/young-female-engineer-coding-over-laptop-in-it-startup-company.jpg" alt="article" class="img-fluid h-100 w-100">
                            </div>
                            <div>
                                <h4 class="fw-3 pt-3" style="color: #ffa400;">Optimiser son environnement de travail</h4>
                                <p class="px-lg-4">Un bon setup n'est pas seulement ésthetique, il influence votre productivite. 
                                    Découvrez comment configurer VS Code et votre bureau pour coider pendant des heures sans fatigue.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6">
                        <div class="">
                            <div class="article">
                                <img src="images/focused-male-computer-programmer-working-on-laptop-at-desk-in-office.jpg" alt="article" class="img-fluid h-100 w-100">
                            </div>
                            <div>
                                <h4 class="fw-3 pt-3" style="color: #ffa400;">Maitriser le résponsive design</h4>
                                <p class="px-lg-4">Créer des sites qui d'adaptent à tout les écrans est dévenu indispensable.
                                    Nous vous donnons les meilleurs méthodes pour utiliser Flexbox un Grid comme un pro.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

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