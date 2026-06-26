<?php include("db_connect.php");

    // Réquète pour récuperer les données de la table articles.

    if (isset($_GET['id']) && (int)$_GET['id'] > 0){
        $id_article = (int)$_GET['id'];
        $req_art = $connect->prepare("SELECT * FROM article WHERE Id_art = ?");
        $req_art->execute([$id_article]);
        $article = $req_art->fetch();
    }
 
    // Requete pour insérer les données dans la table commentaires.

    if (isset($_POST['submit'])){
        $nom = $_POST['nom'];
        $commentaire = $_POST['commentaire'];
        $id_art = $_POST['Id_art'];

        if (isset($_POST['remember_me'])){
            setcookie('sauvegarde_nom', $nom, time() + (86400 * 30), "/");
        }
        else {
            setcookie('sauvegarde_nom', '', time() - 86400, "/");
        }

        if (empty($nom || $commentaire)){
            $erreur = "Veuillez entrez un élément.";
        }
        else{
            $req = $connect->prepare("INSERT INTO commentaires(nom, commentaire, Id_art) 
            VALUES (?, ?, ?)");
            
            $row = $req->execute([$nom, $commentaire, $id_art]);
            if ($row){
                header("Location: single.php?id=" . $id_art . "&success=1");
                exit();
            }
           
        }
    }

    // Je récupère les commentaires pour les affichés
 
    $req = $connect->prepare("SELECT * FROM commentaires WHERE Id_art = ? ORDER BY date DESC");
    $req->execute([$id_article]);
    $row = $req->fetchAll();
    $nbCommentaires = count($row);

    // Requète pour ajouter les données dans la colonne nb_vues(nombre des vues) de la table article.
 
    $req = $connect->prepare("UPDATE article SET nb_vues = nb_vues+1 WHERE Id_art = ?");
    $req->execute([$id_article]); 

    $id_article_courant = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id_article_courant > 0){
        $req = $connect->prepare("SELECT * FROM article WHERE Id_art = ?");
        $req->execute([$id_article_courant]);
        $article_unique = $req->fetch();

        if ($article_unique){
            $i = $article_unique;
            $req_auteur = $connect->prepare("SELECT nom_ut, prenom FROM utilisateurs WHERE Id_ut = ?");
            $req_auteur->execute([$i['Id_ut']]);
            $auteur_art = $req_auteur->fetch();

            $req_nb_com = $connect->prepare("SELECT COUNT(*) AS total FROM commentaires WHERE Id_art = ?");
            $req_nb_com->execute([$i['Id_art']]);
            $comentaire = $req_nb_com->fetch();

            $req_prev = $connect->prepare("SELECT Id_art, nom_art FROM article WHERE Id_art < ? 
            ORDER BY Id_art DESC LIMIT 1");
            $req_prev->execute([$id_article]);
            $article_prev = $req_prev->fetch();

            $req_next = $connect->prepare("SELECT Id_art, nom_art FROM article WHERE Id_art > ? 
            ORDER BY Id_art ASC LIMIT 1");
            $req_next->execute([$id_article]);
            $article_next = $req_next->fetch();
        }
    }

?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Single</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-icons-1.13.1/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg pt-0 pb-0">
                <div class="mastheadd" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)), url('images/<?php echo $i['photo']; ?>');">
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
                                <button class="navbar-toggler toggle mt-3 mb-0 pb-0 bg-light opacity-75" type="button" data-bs-toggle="collapse" data-bs-target="#toggle">
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
                                            <a class="nav-link" href="#">Blog<i class="bi bi-list-stars ps-1"></i></a>
                                            <div>
                                                <ul class="submenu text-end">
                                                    <li class="nav-sub text-center p-1"><a href="blog.php">Blog<i class="bi bi-journal-text"></i></a></li>
                                                    <li class="nav-sub py-1 px-2"><a href='single.php?id=<?php echo $article['Id_art']; ?>'>Single<i class="bi bi-file-earmark-post"></i></a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="login_connexion.php">Se connecter<i class="bi bi-person-plus-fill ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="contact.php">Contact<i class="bi bi-envelope-fill ps-1"></i></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="container">
                            <div class="justify-content-center my-5 single">
                                <h1 class="mt-2 mb-5 text-center text-info fs-1 fw-3"><?php echo htmlspecialchars($i['nom_art']) ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="blog-area" id="blog-area">
            <div class="container">
                <div class="area-wrapper single-post-area row">

                    <div class="blog-right-side col-lg-8">
                        <div class="row mt-4 mt-lg-5">
                            <div class="col-lg-4 col-5">
                                <div class="w-100 text-end">
                                    <a href='single.php?id=<?php echo $i['Id_art']; ?>' class="lien lie active">
                                        <?php echo htmlspecialchars($i['nom_art']); ?>
                                    </a>
                                </div>
                                <ul class="blog-meta" style="list-style: none; padding-left: 0;">
                                    <li class="w-100 text-end lien lie"><?php echo $auteur_art['nom_ut'].' '; echo $auteur_art['prenom']; ?>
                                        <i class="bi bi-person-fill ps-1"></i></li>                                    
                                    <li class="w-100 text-end lien lie"><?php echo date('d/m/Y', strtotime($i['date_pub'])); ?>
                                        <i class="bi bi-calendar ps-1"></i></li>
                                    <li class="w-100 text-end lien lie">Consulter <?php echo $i['nb_vues']; ?> fois
                                        <i class="bi bi-eye-fill ps-1"></i></li>
                                    <li><a href="single.php?id=<?php echo $i['Id_art']; ?> #zone_commentaires" class="lien lie w-100 text-end" ><?php echo $comentaire['total']; ?>  Commentaires
                                        <i class="bi bi-chat-text ps-1"></i></a></li>
                                </ul>
                            </div>
                            <div class="blog-post px-2 col-lg-8 col-7 mb-4">
                                <img src="images/<?php echo $i['photo']; ?>" alt="" class="art img-fluid rounded shadow-sm w-100">
                            </div>
                        </div>

                        <div class="blog-details mt-lg-4">
                            <a href="#" class="lien text-dark">
                                <h3 class="mb-3 h3 text-dark font-weight-bold"><?php echo htmlspecialchars($i['nom_art']); ?></h3>
                            </a>
                            <p><?php echo nl2br(htmlspecialchars($i['description'])); ?></p>
                        </div>

                        <div class="notice">
                            <div class="quote"><?php echo htmlspecialchars($i['nom_art'] . " : " . mb_strimwidth($i['description'], 0, 150, "...")); ?>
                            </div>
                            <div class="notice-detail row row-cols-12 mx-auto w-100 mt-3">
                                <div class="notice-img col-12 col-lg-6 col-md-6">
                                    <img src="images/utsav-srestha-bAEtENrPjf4-unsplash.jpg" alt="categaurie" class="img-fluid w-100" style="height: 90%;">
                                </div>
                                <div class="notice-img col-12 col-lg-6 col-md-6">
                                    <img src="images/young-female-engineer-coding-over-laptop-in-it-startup-company.jpg" alt="categaurie" class="img-fluid w-100" style="height: 90%;">
                                </div>
                            </div>
                            <div class="notice-text">
                                <p>Vous venez de lire l'article dedié à : <strong><?php echo htmlspecialchars($i['nom_art']); ?></strong>.
                                </p>
                                <p>N'hésitez pas à laisser vos impréssions ou vos questions dans la zone de commentaires ci-dessous !
                                </p>
                            </div>
                        </div>

                        <div class="navigation-area row row-cols-6 justify-content-center pe-4 pe-lg-0 ps-lg-2" style="padding-left: 0.7rem;">
                            <div class="nav-left col w-50 justify-content-center ms-0 ps-0"> 
                                <?php if ($article_prev): ?>
                                <div class="row">
                                    <div class="input-group-btn col-lg-2 col-2 pe-lg-0 pe-0">
                                        <a href="single.php?id=<?php echo $article_prev['Id_art']; ?>" class="btn btn-widget btnn" type="button"><i class="bi bii bi-arrow-left"></i></a>
                                    </div>
                                    <div class="details col-lg-10 col-10 ps-4 ps-lg-0" >
                                        <p class="mb-0"><small class="text_muted">Article précédent</small></p>
                                        <a href="single.php?id=<?php echo $article_prev['Id_art']; ?>" 
                                        class="lien text-decoration-none">
                                            <h4 class="fs-6 fw-bold mb-0">
                                                <?php echo htmlspecialchars($article_prev['nom_art']); ?>
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="nav-right col w-50 justify-content-center px-0 mx-0">
                                <?php if ($article_next): ?>
                                <div class="row px-0 mx-0">
                                    <div class="details col-lg-10 col-10 me-lg-0 pe-lg-0" style="padding-right: 0.18rem;">
                                        <p class="mb-0"><small class="text-muted">Article suivant</small></p>
                                        <a href="single.php?id=<?php echo $article_next['Id_art']; ?>" class="lien">
                                            <h4 class="fs-6 fw-bold mb-0">
                                                <?php echo htmlspecialchars($article_next['nom_art']); ?>
                                            </h4>
                                        </a>
                                    </div>
                                    <div class="input-group-btn col-lg-2 col-2 ms-lg-0 ps-lg-0 ps-0">
                                        <a href="single.php?id=<?php echo $article_next['Id_art']; ?>" class="btn btn-widget btnn" type="button"><i class="bi bii bi-arrow-right"></i></a>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="ms-lg-0 me-lg-0 border border-2 p-lg-4 p-2 mt-lg-5 mt-4 w-lg-0" id="zone_commentaires">
                            
                            <div class="pe-2 pe-lg-2" id="commentaire">
                                <h4 class="mb-lg-5 mt-2 mb-4"><?php echo sprintf('%02d', $nbCommentaires); ?> commentaires</h4>
                                <?php foreach ($row as $i){ ?>
                                <div class="border-bottom my-lg-3 mb-2 ps-0 pt-2 pt-lg-0" style="padding-left: 3.2rem;">
                                    <div class="comment-area text-start">
                                        <div class="ms-2">
                                            <h5 class="mb-0">
                                                <a href="#" 
                                                    class="lien text-dark opacity-75 mb-0"><?php echo $i["nom"]; ?>
                                                </a>
                                            </h5>
                                            <div class="comment-option pt-0 mt-0 text-start">
                                                <small style="font-size: 11px; font-style: italic; font-weight: bold;">Posté le <?php echo date('d/m/Y', strtotime($i["date"])); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-start ms-2">
                                        <div class="comment pt-2"><p><?php echo $i["commentaire"] ?></p>
                                    </div>
                                    
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            
                        </div>

                        <div class="comment-form p-3 my-3 border" style="background-color: rgba(243, 252, 255, 0.54);">
                            <h4 class="mb-3 pb-3">Laiser un commentaire</h4>

                            <form action="single.php#commentaire" method="post">

                                <input type="hidden" name="Id_art" value='<?php echo isset($_GET['id']) ? $_GET['id'] : 1; ?>'>
                                
                                <div class="mb-3 w-50">
                                    <input type="text" name="nom" id="remember_me" class="form-control" placeholder="Votre nom" value="<?php echo isset($_COOKIE['sauvegarde_nom']) ? htmlspecialchars($_COOKIE['sauvegarde_nom']) : ''; ?>" aria-describedby="helpId" required/>
                                </div>

                                <div class="mb-3">
                                    <textarea class="form-control" name="commentaire" id="" placeholder="Votre message" required></textarea>
                                </div>

                                <div class="mb-3 form-check d-flex">
                                    <input type="checkbox" name="remember_me" class="form-check-input" id="remember_me"
                                    <?php echo isset($_COOKIE['sauvegarde_nom']) ? 'checked' : ''; ?>>
                                    <label for="remember_me" class="form-label">Enregistrer mon prochain nom pour la prochaine fois.</label>
                                </div>

                                <button type="submit" name="submit" class="btn btnn">Envoyer</button>
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
                                    <strong>Succès !</strong> Commentaire envoyé avec succès.
                                </div>
                                
                                <script>
                                    window.history.replaceState({}, document.title, window.location.pathname);
                                    document.getElementById('message-succes').scrollIntoView({behavior: 'smooth', block: 'center'});
                                </script>
                            <?php } ?>
                            
                        </div>
                    </div>

                    <?php include("asides.php"); ?>

                </div>
            </div>
        </div>

        

        <script src="bootstrap/js/bootstrap.bundle.js" ></script>

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
            }, 4000);

        </script>

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