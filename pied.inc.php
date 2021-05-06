<!-- footer -->
	<footer>
    <div class="footer-content">
			<!-- menu -->
      <ul class="footer-menu">
        <li><a href="index.php">Accueil</a></li>
				<?php
        	echo'<li><a href="index.php?suivant=fiche&amp;id='.$id_dino.'">Découverte</a></li>';
				?>
				<li><a href="index.php?suivant=recherche">Recherche</a></li>
        <?php
          if (isset($_SESSION["pseudo"])){
              echo '
							<li><a href="index.php?suivant=ajout">Ajout</a></li>
							<li><a href="index.php?suivant=profil">'.$_SESSION["prenom"].'</a></li>
							<li><a href="index.php?suivant=deconnexion">Déconnexion</a></li>';
          }
          else {
              echo '<li><a href="index.php?suivant=profil">Profil</a></li>';
          }
        ?>
        <!-- <li class="rss-feed"><a href="#">RSS Feed</a></li> -->
      </ul>
			<!-- texte de pied -->
      <p class="footer-text">
          &copy; 2021 Enclycloposaurus &nbsp; | &nbsp;
          Design by As & Cyr &nbsp; &nbsp;
      </p>
    </div>
		</body>
	</footer>
	<!-- scripts -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.6.1.min.js"><\/script>')</script>
	<script src="js/jquery.smoothscroll.js"></script>
	<script src="js/jquery.nivo.slider.pack.js"></script>
	<script src="js/jquery.easing-1.3.pack.js"></script>
	<script src="js/jquery.fancybox-1.3.4.pack.js"></script>
	<script src="js/init.js"></script>

	</html>
