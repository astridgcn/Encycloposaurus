              <div class="row no-bottom-margin">
              </div>
              <a class="back-to-top" href="#main">Remonter</a>
            </section>
            <section id="liste">
              <h1>Ajout.</h1>
               <h3>Il manque une espèce ? Alors ajoute-là !</h3> <br>
                <p><b>Attention</b> : il faut être <b><a href="profil.php">connecté.e</a></b> pour compléter l'Enclycloposaurus !<br>Si tu ne l'es pas, tu seras amené.e à te <b><a href="profil.php">connecter</a></b> quand tu cliqueras pour ajouter une nouvelle espèce.</p><br>
                  <center>
                    <?php
                      // Si user connecté, direction ajouter
                      if (isset($_SESSION["pseudo"])){
                        echo'
                          <a href="index.php?suivant=ajout"><img src="images/dino/dinovierge.jpg" style="border:3px solid; color:#087013; margin-top:30px" width="289" height="248" alt=""/></a></br></br>
                          <h2><a href="index.php?suivant=ajout">Ajouter un dinosaure</a></h2>';
                      }
                      // Si user pas connecté, direction profil (pour se connecter / s'inscrire)
                      else {
                        echo'
                          <a href="index.php?suivant=profil"><img src="images/dino/dinovierge.jpg" style="border:3px solid; color:#087013; margin-top:30px" width="289" height="248" alt=""/></a></br></br>
                          <h2><a href="index.php?suivant=profil">Ajouter un dinosaure</a></h2>';
                      }
                    ?>
                  </center>
                  <!-- remonter -->
                  <div class="row no-bottom-margin">
                  </div>
                  <a class="back-to-top" href="#main">Remonter</a>
            </section>
          </div>
