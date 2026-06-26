<?php include("db_connect.php");

    // Ici on ajoute les categauries des articles.
            
    if (isset($_POST["submi"])){
        $categaurie = $_POST["categaurie"];
        $description = $_POST["description"];

        // Ici on vérifie si le nom de la catégaurie qu'on veux ajouter néxiste pas encore dans la dase des données.

        if (empty($categaurie)){
            $erreur = "Veuillez entrez une catégaurie";
        }
        else{
            $req = $connect->prepare("SELECT * FROM categaurie_article WHERE nom_cat = ?");
            $req->execute([$categaurie]);
            if ($req->fetch()){
                $erreur = 'Cette catégaurie éxiste déjà.';
            }
            else{
                $req = $connect->prepare("INSERT INTO categaurie_article(nom_cat, description_art) VALUES (?, ?)");
                $row = $req->execute([$categaurie, $description]);
                if ($row){
                    header("Location: admin.php?success=1");
                    exit();
                }
            }
        }
    }

?>

<?php

    // Ici on affiche les catégauries d'articles et on peut les supprimés.

    if (isset($_POST["submit"]) && isset($_POST['id_cat'])){
        $hidden = htmlspecialchars($_POST["id_cat"]);

        $req = $connect->prepare("DELETE FROM categaurie_article WHERE nom_cat = ?");
        $row = $req->execute([$hidden]);
        if ($row){
            header("Location: admin.php?success=2");
            exit();
        }
    }

    // Ici on récupère tout les noms de ctégauries d'article dans la table.

    $req = $connect->prepare("SELECT nom_cat FROM categaurie_article");
    $req->execute();
    $row = $req->fetchAll();

?>

<?php 

    // Réquete pour récuperer les données de la table contact.

    $req = $connect->query("SELECT * FROM contact");
    $messages = $req->fetchAll();

?>

<?php

    // Ici on sécurise notre page administrateur. Si quelqu'un n'est pas administrateur, il ne
    // peut pas accéder à la page; il séra rédiriger directement sur la page d'acceuil. 
    // On a aussi la requete qui sert à afficles le nom, email et role des utilisateurs et 
    // adiministrateurs.

    session_start();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrateur'){
        header('location: index.php');
        exit();
    }
    else{
    
        if (isset($_POST["update_role"])){
            $role = $_POST["role"];
            $user_id = $_POST["user_id"];

            if ($role == ""){
                $erreur = "Veuillez choisir un émément";
            }
            else{
                $req = $connect->prepare("UPDATE utilisateurs SET role = ? WHERE Id_ut = ?");
                $req->execute([$role, $user_id]);
                $message = "Role mis à jour avec succès !";
            }
        }
    }

    $req = $connect->prepare("SELECT Id_ut, prenom, email, role FROM utilisateurs");
    $req->execute();
    $utilisateurs = $req->fetchAll();

    if (isset($_POST["update_config"])){
        $adresse = $_POST["adresse"];
        $details = $_POST["details"];
        $telephone = $_POST["telephone"];
        $horaire = $_POST["horaire"];
        $mail = $_POST["mail"];

        if (true){
            $req = $connect->prepare("UPDATE adresse SET adress = ?, details = ?, 
            telephone = ?, horaire = ?, email = ? WHERE Id_adr = 1");
            $req->execute([$adresse, $details, $telephone, $horaire, $mail]);
            $message = "Coordonnés mis à jour avec succès !";
        }
        else{
            $erreur = "Echec de mis en jour.";
        }
    }

    $req = $connect->prepare("SELECT * FROM adresse");
    $req->execute();
    $coordonnes = $req->fetchAll();

?>

<!DOCTYPE html>

<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
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
                                            <a class="nav-link text-warning" href="login_articles.php">Article<i class="bi bi-pencil-fill ps-1"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-warning" href="login_connexion.php">Se connecter<i class="bi bi-person-plus-fill ps-1"></i></i></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                
            </nav>
        </header>

        <h3 class="text-center fw-bold mt-5">Géstion des adminiatrateurs et utilisateurs</h3>

        <div class="table-responsive-sm mx-5 mb-5 mt-4">
            <table class="table table-secondary table-hover table-bordered">
                <thead class="table-dark opacity-75">
                    <caption>
                        Ajouter ou rétirer un administrateur
                    </caption>
                    <tr>
                        <th scope="col" class="text-light" style="background-color: #ffa400;">Pseudo</th>
                        <th scope="col" class="text-light" style="background-color: #ffa400;">Email</th>
                        <th scope="col" class="text-light" style="background-color: #ffa400;">Role</th>
                        <th scope="col" class="text-light" style="background-color: #ffa400;">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider"> <?php foreach ($utilisateurs as $i){ ?>
                    <tr class="">
                        <td><strong><?php echo htmlspecialchars($i['prenom']); ?></strong></td>
                        <td><?php echo htmlspecialchars($i['email']); ?></td>
                        <td><span>
                        <?php echo strtoupper($i['role']); ?>
                        </span></td>
                        <td><form action="" method="post" class="d-flex gap-2 justify-content-center">
                                <input type="hidden" name="user_id" value="<?php echo $i['Id_ut']; ?>">
                                <select name="role" class="form-select-sm" id="" style="width: 100px;">
                                    <option value="" required>Choisissez</option>
                                    <option value="utilisateur">Utilisateur</option>
                                    <option value="administrateur">Administrateur</option>
                                </select>

                                <button type="submit" name="update_role" class="btn btn-sm text-light" style="background-color: #ffa400";>Ajouter<i class="bi bi-check-circle ms-1"></i></button>
                            </form>
                        </td>
                    </tr>
                    
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row my-5 px-2 px-lg-5 py-5 justify-content-center" style="background-color: #e8e8e8ff">
            <h3 class="text-center fw-bold mb-5">Ajout de catégaurie d'article</h3>
            <div class="table-responsive-sm col-12 col-lg-8 col-md-8">

                <table class="table table-hover align-middle table-bordered border-secondary">
                    <thead class="border bordered">
                        <caption>
                            Ajouter ou supprimer une categaurie
                        </caption>
                        <tr>
                            <th class="bg-warning opacity-75 text-light">Ajouter une categaurie</th>
                            <th class="bg-warning opacity-75 text-light">Categauries</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php foreach ($row as $i){ ?>
                        <tr class="table-primary">
                            <td scope="row"><?php echo htmlspecialchars($i['nom_cat']); ?></td>
                            <td scope="row">
                                <form action="" method="post">
                                    <input type="hidden" name="id_cat" value='<?php echo $i['nom_cat']; ?>' required>
                                    <button type="submit" name="submit" class="btn btn-sm btn-danger ms-2">Supprimer<i class="bi bi-trash3-fill ms-1"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <?php if(isset($_GET['success']) && $_GET['success'] == 2){?>
                    <div class="alert alert-success alert-dismissible fade show ms-auto me-auto mt-3" role="alert" id="message-succes">
                    <i class="bi bi-check-circle-fill"></i>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>
                        <strong>Succès !</strong> Catégaurie supprimer avec succès.
                    </div>
                    
                    <script>
                        window.history.replaceState({}, document.title, window.location.pathname);
                        document.getElementById('message-succes').scrollIntoView({behavior: 'smooth', block: 'center'});
                    </script>
                <?php } ?>

            </div>

            <div class="col-md-4 col-lg-4">
                <div class="card-header bg-white border-0 pt-3 px-2 pb-4">
                    <div class="fw-bold mb-2">Publication</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-4">
                                <label for="" class="form-label fw-bold small text-uppercase text-muted">Catégaurie</label>
                                <input type="text" name="categaurie" class="form-control" id="" placeholder="Entrez nom catégaurie">
                            </div>
                            <div class="mb-4">
                                <label for="" class="form-label fw-bold small text-uppercase text-muted">Déscription</label>
                                <input type="text" name="description" class="form-control" id="" placeholder="Entrez la déscription">
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" name="submi" class="btn btn-warning fw-bold py-2 shadow-sm">
                                    <i class="bi bi-cloud-arrow-up-fill me-2">Ajouter catégaurie</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
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
                        <strong>Succès !</strong> Categaurie ajouter avec succès.
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

        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-dark text-white text-center py-3">
                            <h5 class="mb-0 fw-bold">Modifier les coordonnées du site</h5>
                        </div>
                        <div class="card-body p-4">
                            <?php foreach ($coordonnes as $co){ ?>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="site_adresse_id" class="form-label fw-semibold text-secondary">Adresse (Ex: Nord-kivu, R.D.Congo)</label>
                                    <input type="text" name="adresse" id="adresse" class="form-control" value="<?php echo $co["adress"]; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="site_adresse_id" class="form-label fw-semibold text-secondary">Details (Ex: Butembo, Av.semuliki, N° 24)</label>
                                    <input type="text" name="details" id="details" class="form-control" value="<?php echo $co["details"]; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="site_adresse_id" class="form-label fw-semibold text-secondary">Téléphone (Ex: 00(+243) 972430698)</label>
                                    <input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo $co["telephone"]; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="site_adresse_id" class="form-label fw-semibold text-secondary">Horaire (Ex: Lun à Ven, 8h00 à 17h00)</label>
                                    <input type="text" name="horaire" id="horaire" class="form-control" value="<?php echo $co["horaire"]; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="site_adresse_id" class="form-label fw-semibold text-secondary">Email de contact</label>
                                    <input type="text" name="mail" id="email" class="form-control" value="<?php echo $co["email"]; ?>" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" name="update_config" class="btn btn-warning fw-bold text-dark py-2">
                                        <i class="bi bi-check-circle-fill me-2"></i>Enrégistrer les modifications
                                    </button>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <caption>
                Ajouter ou supprimer une categaurie
            </caption>
        </div>

        <div class="container my-5">

            <h2 class="mb-4 text-center fw-bold">Boite de réception des messages.</h2>
            
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-secondary table-hover table-bordered">
                    <thead class="table-dark opacity-75">
                        <caption>
                            Réception de messagerie
                        </caption>
                        <tr>
                            <th scope="col" class="text-light" style="width: 15%; background: darkgray;">Date</th>
                            <th scope="col" class="text-light" style="width: 20%; background: darkgray;">Expéditeur</th>
                            <th scope="col" class="text-light" style="width: 20%; background: darkgray;">Email</th>
                            <th scope="col" class="text-light" style="width: 20%; background: darkgray;">Sujet</th>
                            <th scope="col" class="text-light" style="width: 25%; background: darkgray;">Message</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php foreach ($messages as $msg){ ?>
                        <tr>
                            <td class="text-nowrap text-muted"><?php echo htmlspecialchars($msg['date']) ?></td>
                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($msg['nom']) ?></td>
                            <td><a href="mailto: <?php echo htmlspecialchars($msg['email']) ?>" class="text-decoration-none"><?php echo htmlspecialchars($msg['email']) ?></a></td>
                            <td class="text-primary fw-semibold"><?php echo htmlspecialchars($msg['sujet']) ?></td>
                            <td class="text-dark"><?php echo htmlspecialchars($msg['message']) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

        <footer class="footer pt-4 mt-2" id="footer">
            <div class="row footer-blocks">
                <div class="col-lg-4 footer-block f-links">
                    <ul>
                        <li><a href="aPropos.php">A propos de nous</a></li>
                        <li><a href="contact.php" class="mt-3">Nous écrire</a></li>
                        <li><a href="confidentialite.php" class="mt-3">Politique de confidentialité</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 footer-block s-links">
                    <ul class="">
                        <li><a href="#"><i class="bi bi-facebook ms-4"></i></a></li>
                        <li><a href="#"><i class="bi bi-twitter ms-4"></i></a></li>
                        <li><a href="#"><i class="bi bi-youtube ms-4"></i></a></li>
                        <li><a href="#"><i class="bi bi-instagram ms-4"></i></a></li>
                    </ul>
                </div>

                <div class="col-lg-4 copyright text-center" id="copyright">
                    &copy; | Nickson code <script>document.write(new Date().getFullYear());</script> All rights reserved
                </div>
                
            </div>
        </footer>

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
            }, 5000);

        </script>

    </body>
    
</html>