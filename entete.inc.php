<?php
	session_start();
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html> <!--<![endif]-->
	<head>
	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	  <meta charset="utf-8"/>
	  <meta name="description" content="">
	  <meta name="author" content="Bonnin.C, Guiochon.A">

	  <title>Enclycloposaurus</title>

		<!-- CSS et lgoo -->
	  <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	  <link rel="stylesheet" href="css/nivo-slider.css" type="text/css" />
	  <link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" />
	  <link rel="icon" type="image/png" sizes="16x16" href="images/logo.png">

	<!--[if lt IE 9]>
	    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	</head>

  <body>
    <!-- header-wrap -->
    <div id="header-wrap">
      <header>
        <hgroup>
          <h2 style="color:#E3FCD9; font-size:36px">Encycloposaurus</h2>
        </hgroup>
					<!-- menu -->
          <nav>
            <ul>
              <li><a href="index.php">Accueil</a></li>
							<?php
							$id_dino = random_int(1, 106);
              echo'<li><a href="index.php?suivant=fiche&amp;id='.$id_dino.'">Découverte</a></li>';
							?>
              <li><a href="index.php?suivant=recherche">Recherche</a></li>
              <?php
              if (isset($_SESSION["prenom"])){
                  echo '
									<li><a href="index.php?suivant=ajout">Ajout</a></li>
									<li><a href="index.php?suivant=profil">'.$_SESSION["prenom"].'</a></li>
									<li><a href="index.php?suivant=deconnexion">Déconnexion</a></li>';
              }
              else {
                  echo '<li><a href="index.php?suivant=profil">Profil</a></li>';
              }
              ?>
            </ul>
          </nav>
						<!-- fin menu -->
        </header>
    </div>
