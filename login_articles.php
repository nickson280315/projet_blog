<?php include("db_connect.php");

    session_start();

    if (!isset($_SESSION['id_ut'])){
        if (!isset($_COOKIE['remember_token'])){
            $token_recu = $_COOKIE['remember_token'];

            $req = $connect->prepare("SELECT * FROM utilisateurs WHERE remember_token = ?");
            $req->execute([$token_recu]);
            $user_trouve = $req->fetch();

            if ($user_trouve){
                $_SESSION['role'] = $user_trouve['role'];
                $_SESSION['id_ut'] = $user_trouve['Id_ut'];
            }
            else{
                header("Location: login_connexion.php");
                exit();
            }
        }
        else{
            header("Location: login_connexion.php");
            exit();
        }
    }

    // Réquète pour récuperer les données de la table categaurie_article

    $req = $connect->prepare("SELECT * FROM categaurie_article");
    $req->execute();
    $roww = $req->fetchAll();

    // Requete pour insérer les données dans la table article.

    if (isset($_POST["submit"])){
        $name = htmlspecialchars(trim($_POST["titre"]));
        $description = htmlspecialchars(trim($_POST["description"]));
        $id_auteur = isset($_SESSION["id_ut"]) ? $_SESSION["id_ut"] : NULL;
        if ($id_auteur == NULL || $id_auteur == 0){
            $id_auteur = 1;
        }
        $id_cat = htmlspecialchars(trim($_POST["id_cat"]));
        $nb_vues = 0;

        $photo = "";
        $target_file = "";
        $upload_ok = true;

        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
            $nom_origine = basename($_FILES["photo"]["name"]);
            $nom_extension = strtolower(pathinfo($nom_origine, PATHINFO_EXTENSION));
            
            $extensions_autorisees = ["jpg", "jpej", "png", "gif", "webp"];
            
            if (in_array($nom_extension, $extensions_autorisees)){
                $photo = uniqid() . "_" . $nom_origine;
                $target_dir = "images/";
                $target_file = $target_dir . $photo;
            }
            else{
                $erreur = "Format d'images non valide (JPG, PNG, GIF, WEBP uniquement).";
                $upload_ok = false;
            }
        }
        else
        {
            echo "fichier non récu";
        }
        if ($name && $description && $id_auteur !== NULL){
            if (strlen($name) <= 4){
                $erreur = "Le champs doit conténir plus ou moin 5 caractères.";
            }
            elseif (strlen($description) <= 50){
                $erreur = "Le champs doit conténir plus ou moin 50 caractères.";
            }
            else{
                $req = $connect->prepare("INSERT INTO article(nom_art, description, nb_vues, 
                photo, Id_ut, Id_cat) VALUES (?, ?, ?, ?, ?, ?)");
                $req->execute([$name, $description, $nb_vues, $photo, $id_auteur, $id_cat]);
                if ($req){
                    if (isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name'] != ''){
                        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
                    }
                    header("Location: login_articles.php?success=1");
                    exit();
                }
                else{
                    $erreur = "Elément entré invalide";
                }
            }
        }
        else{
            $erreur = "Veuillez remplir tous les champs";
        }
    }

    // Réquète pour récuperer les données de la table utilisateurs.

    $id = $_SESSION['id_ut'];
    $req = $connect->prepare("SELECT * FROM utilisateurs WHERE Id_ut = ?");
    $req->execute([$id]);
    $row = $req->fetchAll();

?>

<!DOCTYPE html>

<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Article</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-icons-1.13.1/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body style="background-color: #e8e8e8ff">

        <nav class="navbar navbar-expand-lg navbar-warning shadow-sm py-3 opacity-75" style="background-color: #ffa400;">
            <div class="container">
                <a class="navbar-brand fw-bold" href="login_articles.php"><i class="bi bi-journal-richtext me-2"></i>Espace rédacteur</a>
                <div class="d-flex align-items-center">

                    <?php foreach ($row as $role){ ?>
                        <span class="me-2">Connecté en tant que <strong><?php echo $role['role']; ?></strong></span>
                    <?php } ?>
                    
                    <a href="index.php" class="btn btn-outline-light btn-sm">Quitter</a>
                </div>
            </div>
        </nav>

        <div class="container pb-5">
            <div class="my-5">
                <?php 

                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur'){
                        echo '<button type="button" class="btn btn-warning"><a href="admin.php" style="font-weight:500; text-decoration: none; color: #000000ff;">Accéder au panneau d\'administration<a/></button>';
                    }

                ?>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-10">
                    <form action="login_articles.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card shadow-sm border-0 mb-4">
                                    <div class="card-body p-4">
                                        <div class="mb-4">
                                            <label for="" class="form-label fs-5 fw-bold text-secondary">Titre de l'article</label>
                                            <input type="text" name="titre" class="form-control form-control-lg bg-light" placeholder="Entrez un titre" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label fs-5 fw-bold text-secondary">Contenu</label>
                                            <textarea name="description" class="form-control bg-light rows-12" placeholder="Commencer à écrire votre article ici..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-md-4">
                                <div class="card-header bg-white border-0 pt-3 px-2">
                                    <div class="fw-bold mb-0">Publication</div>
                                    <div class="card-body">

                                        <div class="mb-4">
                                            <label for="" class="form-label fw-bold small text-uppercase text-muted">Image de couverture</label>
                                            <div class="input-group">
                                                <label for="InputGroupFile01" class="input-group-text bg-white w-100"><i class="bi bi-camera me-1"></i>
                                                    <input type="file" id="photo" name="photo" accept="image/*" class="form w-100" required><i class="bi bi-image"></i>
                                                </label>
                                            </div>
                                            <div id="emailHelp" class="form-text">Formats acceptés : JPG, PNG (Max 2Mo).</div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="" class="form-label fw-bold small text-uppercase text-muted">Catégaurie</label>
                                            <select name="id_cat" class="form-select bg-light" id="" required>
                                                <option value="" disabled selected>Choisissez une catégaurie</option>
                                                
                                            <?php foreach ($roww as $i){ ?>

                                                <option value="<?php echo $i['Id_cat'];?>"><?php echo $i['nom_cat'];?></option>
                                                
                                            <?php } ?>

                                            </select>

                                        </div>

                                        <hr>

                                        <div class="d-grid gap-2">
                                            <button type="submit" name="submit" class="btn btn-warning fw-bold py-2 shadow-sm">
                                                <i class="bi bi-cloud-arrow-up-fill me-2">Publier l'article</i>
                                            </button>

                                        </div>
                                    </div>
                                    <div class="alert alert-warning border-0 shadow-sm small mt-2">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        Toute publication sur le blog est instantanée et publique.
                                    </div>
                                </div>

                            </div>
                        </div>
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
                            <strong>Succès !</strong> Article publier avec succès.
                        </div>
                        
                        <script>
                            window.history.replaceState({}, document.title, window.location.pathname);
                            document.getElementById('message-succes').scrollIntoView({behavior: 'smooth', block: 'center'});
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
                    <?php } ?>

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