<?php include("db_connect.php");

    $req_menu = $connect->query("SELECT * FROM categaurie_article LIMIT 3");
    $categaurie = $req_menu->fetchAll();

   $articleParPage = 4;
   $page_actuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
   if ($page_actuelle <= 0)
     {$page_actuelle = 1;}

   $search = isset($_GET['search']) ? trim($_GET['search']) : '';
   $id_cat_filtre = (isset($_GET['cat']) && $_GET['cat'] !== '') ? (int) $_GET['cat'] : null;
   $url_search = !empty($search) ? '&search=' . urlencode($search) : '';
   $url_cat = ($id_cat_filtre !== null) ? '&cat=' . urlencode($id_cat_filtre) : '';

   $conditions = [];
   $params = [];

   if (!empty($search)) {
    $conditions[] = "(nom_art LIKE :search OR description LIKE :search)";
    $params[':search'] = '%' . $search . '%';
   }

   if ($id_cat_filtre !== null){
     $conditions[] = "Id_cat = :id_cat";
     $params[':id_cat'] = $id_cat_filtre;
    }

    $whereClause = "";
    if (count($conditions) > 0){
        $whereClause = "WHERE " . implode(" AND ", $conditions);
    }

    $sql_count = "SELECT COUNT(*) FROM article $whereClause";
    $req_total = $connect->prepare($sql_count);
    $req_total->execute($params);
    $totalArticles = $req_total->fetchColumn();

    $nbTotalPage = ceil($totalArticles / $articleParPage);
    if ($page_actuelle > $nbTotalPage && $nbTotalPage > 0){
        $page_actuelle = $nbTotalPage; }

    $depart = ($page_actuelle - 1) * $articleParPage;

    $sql_articles = "SELECT * FROM article $whereClause ORDER BY Id_art DESC LIMIT :depart, :parPage";
    $req_art = $connect->prepare($sql_articles);

    foreach ($params as $key => $value){
        if ($key === ':id_cat'){
            $req_art->bindValue($key, $value, PDO::PARAM_INT);
        }
        else{
            $req_art->bindValue($key, $value, PDO::PARAM_STR);
        }
    }
    
    $req_art->bindValue(':depart', $depart, PDO::PARAM_INT);

    $req_art->bindValue(':parPage', $articleParPage, PDO::PARAM_INT);

    $req_art->execute();
    $articles = $req_art->fetchAll();

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
                                <button class="navbar-toggler toggle mt-3 mb-0 pb-0 border border-dark" type="button" data-bs-toggle="collapse" data-bs-target="#toggle">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse justify-content-end col-lg-4" id="toggle">
                                <div>
                                    <ul class="navbar-nav align-items-end me-4">
                                        <li class="nav-item">
                                            <a class="nav-link text-warning" href="index.php">Acceuil<i class="bi bi-house-fill ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-warning" href="blog.php">Blog<i class="bi bi-journal-text ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-warning" href="login_connexion.php">Se connecter<i class="bi bi-person-plus-fill ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-warning" href="contact.php">Contact<i class="bi bi-envelope-fill ps-1"></i></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                
            </nav>
        </header>

        <section>
            <div class="py-3">
                <h1 class="pt-2 py-3 mx-2 mx-lg-0" style="color: #ffa400;">Le Blog de la Connaissance Tech</h1>
                <p class="px-3">Plonger dans l'univers du développement web et de la techonologie.
                    Que vous fassiez vos prémiers pas en HTML ou que vous soyez un éxpert en architecture
                    logicielle, nos articles sont concue pour enrichir vos compétences au quotidien.
                </p>
                <p class="px-3">Découvrez des tutoriels détaillés, des analyses sur des nouveaux framworks
                    et des conseils pour optimiser votre environnement du travail. La connaissance ne 
                    vaut que si elle est partagées, alors n'hésitez pas à interagir avec la communauté!
                </p>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row row-cols-lg-4 justify-content-center">
                    
                    <?php foreach ($categaurie as $cat) { ?>

                    <div class="col col-12 col-md-4 categaurie-post">
                        <div class="mx-2 mb-3">
                            <img src="images/numan-ali-llNtovr7ctk-unsplash.jpg" alt="categaurie" class="img-fluid phh">
                        </div>
                        <div class="categaurie-detail">
                            <div class="categaurie-text">
                                <a href="blog.php?cat=<?php echo $cat['Id_cat']; ?> #categorie " class="lien">
                                    <h5 class="h5"><?php echo htmlspecialchars($cat["nom_cat"]); ?></h5>
                                </a>
                                <a href="blog.php?cat=<?php echo $cat['Id_cat']; ?> #categorie " class="lien text-light opacity-100">
                                    <p class="para"><?php echo htmlspecialchars($cat["description_art"]); ?></p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php } ?>

                </div>
            </div>
        </section>

        <section id="blog-area" class="blog-area py-2">
            <div class="container" id="categorie">
                <div class="area-wrapper row" id="recherche">
                    <div class="col-lg-8 pe-5" id="desabled">

                        <?php if (!empty($articles)): ?>

                            <?php foreach ($articles as $i){ ?>

                            <article class="mt-5">
                                <div class="row">
                                    <div class="col-lg-4 col-5">
                                        <div class="w-100 text-end">
                                            <a href='single.php?id=<?php echo $i['Id_art']; ?>' class="lien lie active">
                                                <?php echo htmlspecialchars($i['nom_art']); ?>
                                            </a>
                                        </div>
                                        <ul class="blog-meta" style="list-style: none; padding-left: 0;">
                                            <?php

                                                // Requète pour tous les données de la vue commentaires.
                                                $req_nb_com = $connect->prepare("SELECT COUNT(*) AS total FROM commentaires WHERE Id_art = ?");
                                                $req_nb_com->execute([$i['Id_art']]);
                                                $commentaire = $req_nb_com->fetch();

                                                // Requète pour récuperer tous les données des colonnes nom_ut, prenom vue dans la table utilisateurs.
                                                $req_auteur = $connect->prepare("SELECT nom_ut, prenom FROM utilisateurs WHERE Id_ut = ?");
                                                $req_auteur->execute([$i['Id_ut']]);
                                                $auteur_art = $req_auteur->fetch();
                                                
                                            ?>
                                            <li class="w-100 text-end lien lie"><?php echo $auteur_art['nom_ut'].' '; echo $auteur_art['prenom']; ?>
                                                <i class="bi bi-person-fill ps-1"></i></li>                                    
                                            <li class="w-100 text-end lien lie"><?php echo date('d/m/Y', strtotime($i['date_pub'])); ?>
                                                <i class="bi bi-calendar ps-1"></i></li>
                                            <li class="w-100 text-end lien lie">Consulter <?php echo $i['nb_vues']; ?> fois
                                                <i class="bi bi-eye-fill ps-1"></i></li>
                                            <li><a href="single.php?id=<?php echo $i['Id_art']; ?> #zone_commentaires" class="lien lie w-100 text-end" ><?php echo $commentaire['total']; ?>  Commentaires
                                                <i class="bi bi-chat-text ps-1"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="blog-post px-2 col-lg-8 col-7 mb-4">
                                        <img src="images/<?php echo $i['photo']; ?>" alt="article" class="art img-fluid rounded shadow-sm w-100">
                                        <div class="blog-details mt-3 mb-2">
                                            <a href="#" class="lien text-dark"><h3 class="mb-3 h3">
                                                <?php echo $i['nom_art']; ?></h3></a>
                                            <p><?php $extr = strip_tags($i['description']);
                                                echo strlen($extr) > 100 ? substr($extr, 0, 100) . "..." : $extr;?></p>
                                            <a href='single.php?id=<?php echo $i['Id_art']; ?>'>
                                                <button type="button" class="btn btnn">Lire l'article</button></a>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <?php } ?>

                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php $url_cat = ($id_cat_filtre) ? '&cat=' . $id_cat_filtre : ''; ?>
                                    <li class="page-item <?php if ($page_actuelle <= 1){echo 'disabled'; } ?>">
                                        <a class="page-link" 
                                        href="blog.php?page=<?php echo $page_actuelle - 1 . $url_cat; ?> #desabled" 
                                        aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <?php for ($i = 1; $i <= $nbTotalPage; $i++){ ?>
                                    <li class="page-item <?php if ($page_actuelle == $i){ echo 'active';} ?>" 
                                        aria-current="page">
                                        <a class="page-link" 
                                        href="blog.php?page=<?php echo $i . $url_cat; ?> #desabled"><?php echo $i; ?></a>
                                    </li>
                                    <?php } ?>

                                    <li class="page-item <?php if ($page_actuelle >= $nbTotalPage){echo 'disabled'; } ?>" >
                                        <a class="page-link" 
                                        href="blog.php?page=<?php echo $page_actuelle + 1 . $url_cat; ?> #desabled">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav> 
                        <?php else: ?>
                            <div class="alert alerte alert-warning mt-5 p-lg-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2"></i>
                                <strong>Aucun article trouve !</strong> Le mot-clé ne conrespond à aucun contenue.
                            </div>

                        <?php endif ?>
    
                    </div>

                    <?php include("asides.php"); ?>

                </div>
            </div>
        </section>

        <footer class="footer pt-4 mt-2" id="footer">
            <div class="row footer-blocks">
                <div class="col-lg-4 col-md-4 footer-block f-links">
                    <ul>
                        <li><a href="#">A propos de nous</a></li>
                        <li><a href="contact.php" class="mt-3">Nous écrire</a></li>
                        <li><a href="#" class="mt-3">Politique de confidentialité</a></li>
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