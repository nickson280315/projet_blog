<?php include("db_connect.php");

    // Réquète pour insérer les emails dans la table newsletter.
    
    if (isset($_POST['submit_mail'])){
        $mail = $_POST["mail"];
        if ($mail){
            $req = $connect->prepare("INSERT INTO newsletter(email) VALUES (?)");
            $req->execute([$mail]);
        }
    }

?>

<div class="col-lg-4 mt-5" style="background-color: rgb(240, 240, 240);">

    <aside class="single-sidebar-widget search-widget mt-4">
        
        <form action="blog.php #recherche" method="GET">
            <?php if (isset($id_cat_filtre) && $id_cat_filtre !== null){ ?>
                <input type="hidden" name="cat" value="<?php echo htmlspecialchars($id_cat_filtre); ?>">
            <?php } ?>
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Rechercher article" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <span class="input-group-btn">
                    <button class="btn btn-widget btnn" type="submit" name="submit"><i class="bi bi-search ps-1"></i></button>
                </span>
            </div>
        </form>

    </aside>

    <aside class="mt-4">
        <div class="single-sidebar-widget author-widget">
            <div class="avatar-wrapper ">
                <img src="images/20260217_110007.jpg" alt="auteur" class="img-fluid w-100 h-100 rounded-circle object-fit-cover">
            </div>
            <h4>Nickson Code</h4>
            <p>Bloggeur pro</p>
            <div class="social-icone pb-3">
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-twitter px-4"></i></a>
                <a href=""><i class="bi bi-github"></i></a>
            </div>
            <p>Rejoignez la communauté de développeurs ! 
                Recevez directement dans votre boite mail 
                une alerte dès qu'un nouvel article ou un tutoriel exclusif est publié sur le blog. 
                Guaranteed 100% tech, sans spam.                                
            </p>
            <div class="br"></div>
        </div>
    </aside>

    <aside class="single-sidebar-widget newsletter-widget">
        <h4 class="widget-title mb-3 bg-warning">Newsletter</h4>
        <p>Passionné de développement web et de nouvelles tehnologies. 
            Je partage ici mes tutoriels, mes astuces de programmation (PHP, JavaScript, POO)
                et mon quotidien de développeur pour vous aider à progresser chaque jour.
        </p>
        <div class="form-group">
            <form action="" method="post">
            <div class="input-group justify-content-center bg-light">
                <div class=" pt-2 border"  style="background-color: rgb(255, 255, 255); "><i class="bi bi-envelope me-2 ps-2"></i></div>
                <input type="email" name="mail" class="form-control" placeholder="Entrez email">
                <span class="input-group-btn">
                    <button class="btn btn-widget btnn" type="submit" name="submit_mail">S'inscrire</button>
                </span>
            </div>
            </form>
        </div>
        <p class="text-bottom"><small>Votre adresse email reste 100% confidentielle.</small></p>
        <div class="br"></div>
    </aside>

    <aside class="single-sidebar-widget tag-cloud-widget">
        <h4 class="widget-title mb-3 bg-warning">Liste des étiquetes</h4>
        <ul class="list d-flex justify-content-center">
            <li class="lien li"><a href="blog.php?search=Technologie" class="lien a">Techologie</a></li>
            <li class="lien li"><a href="blog.php?search=Java" class="lien a">Java</a></li>
            <li class="lien li"><a href="blog.php?search=PHP" class="lien a">PHP</a></li>
            <li class="lien li"><a href="blog.php?search=Java script" class="lien a">JavaScript</a></li>
            <li class="lien li"><a href="blog.php?search=Python" class="lien a">Python</a></li>
            <li class="lien li"><a href="blog.php?search=CSS" class="lien a">CSS</a></li>
            <li class="lien li"><a href="blog.php?search=Laravel" class="lien a">Laravel</a></li>
            <li class="lien li"><a href="blog.php?search=Smphony" class="lien a">Symfony</a></li>
            <li class="lien li"><a href="blog.php?search=POO" class="lien a">POO</a></li>
            <li class="lien li"><a href="blog.php?search=Twig" class="lien a">Twig</a></li>
            <li class="lien li"><a href="blog.php?search=Web" class="lien a">Web</a></li>
            <li class="lien li"><a href="blog.php?search=Mobile" class="lien a">Mobile</a></li>
        </ul>
    </aside>
    
</div>


