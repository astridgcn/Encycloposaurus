<?php
echo'
<!-- content-wrap -->
      <div class="content-wrap">
          <!-- main -->
          <section id="main">
            <div class="intro">
              <h1>Profil.</h1>
                <h3>C\'est ici que tu peux visualiser les informations te concernant.</h3><br>
                    <h2>'.$_SESSION["prenom"].'</h2>
                    <ul>
                      <li><b>Pseudo : </b>'.$_SESSION["pseudo"].'</li>
                      <li><b>Mail : </b>'.$_SESSION["mail"].'</li>
                    </ul>
            </div>
            <!-- remonter -->
            <div class="row no-bottom-margin">
            </div>
            <a class="back-to-top" href="#main">Remonter</a>
          </section>
        </div>';
?>
