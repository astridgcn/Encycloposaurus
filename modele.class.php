<?php
  // - - -

  // Classe d'exécution de requête
  require("exec.class.php");

  // Classe des templates
  require("template.class.php");

  // - - -

  /* Classe de requêtes */
  class Req extends Requete {

    /* Fonction d'affichage des listes de dinosaures (accueil et recherche) */
    public function afficherTab() {
      // Création nouveau template
      $gab = new Template("./");
      $gab->set_filenames(array("body"=>"tab.tpl.html"));
      $gab->assign_vars(array("nom"=>$this->nom));
      // Si la requête possède au moins un résultat
      if (!empty($this->data)) {
        echo '<h4>Voilà la liste des dinosaures qui correspondent à tes critères !</h4></br>';
        // Pour chaque ligne de résultats (de la requête)
        foreach($this->data as $row){
          // Remplissage du tableau en lignes
          $gab->assign_block_vars("ligne", array("id"=>$row["id_dino"],"nomd"=>$row["nom_dino"],"sous_ordre"=>$row["sous_ordre"],"ordre"=>$row["ordre"],"epoque"=>$row["periode"]));
        }
        // Stocker dans cible le nom de la page actuelle
        $gab->assign_vars(array('cible' => $_SERVER["PHP_SELF"] ));
        // Affichage du gabarit
        $gab->pparse("body");
      }
      // Si la requête est vide
      else {
        echo'<h4>Aucune espèce ne correspond à tes critères.</h4>';
      }
    }

    /* Fonction d'affichage des informations d'une espèce */
    public function Dinofiche() {
      // Création nouveau template
      $gab = new Template(";/");
      $gab -> set_filenames(array("body"=>"dinofiche.tpl.html"));
      $gab->assign_vars(array("nom"=>$this->nom));
      // Pour chaque ligne de résultats (de la requête)
      foreach ($this->data as $dino){
        // Remplissage des cases
        $gab->assign_vars(array("nomd"=>$dino["nom_dino"]));
        $gab->assign_vars(array("ssordre"=>$dino["sous_ordre"]));
        $gab->assign_vars(array("ordre"=>$dino["ordre"]));
        $gab->assign_vars(array("epoque"=>$dino["periode"]));
        $gab->assign_vars(array("milieu"=>$dino["milieu_vie"]));
        $gab->assign_vars(array("locomotion"=>$dino["mode_locomotion"]));
        $gab->assign_vars(array("reproduction"=>$dino["repro"]));
        $gab->assign_vars(array("regime"=>$dino["regime_alim"]));
        $gab->assign_vars(array("img"=>$dino["img_dino"]));
      }
      // Affichage du gabarit
      $gab->pparse("body");
    }

    /* Fonction d'affichage des listes déroulantes de recherche */
    public function liste1($x, $y) {
      // Création nouveau template
      $gab = new Template("./");
      // Template avec option par défaut "Tous"
      $gab -> set_filenames(array("body"=>"liste.tpl.html"));
      $gab->assign_vars(array("nom" => $this->nom));
      // Nom de la liste
      $gab->assign_vars(array("cle" => $y));
      // Pour chaque ligne de résultats (de la requête)
      foreach ($this->data as $value) {
        // Remplissage de la liste
        $gab->assign_block_vars("sel", array("option" => $value[$x],"id" => $value[$y]));
      }
      // Affichage du gabarit
      $gab->pparse("body");
  }

    /* Fonction d'affichage */
    public function liste2($x, $y) {
      // Création nouveau template
        $gab = new Template("./");
        $gab->set_filenames(array("body"=>"ajout.tpl.html"));
        // Template avec option par défaut "Choisir" non sélectionnable
        $gab->assign_vars(array("nom" => $this->nom));
        // Nom de la liste
        $gab->assign_vars(array("cle" => $y));
        // Pour chaque ligne de résultats (de la requête)
        foreach ($this->data as $value) {
          // Remplissage de la liste
            $gab->assign_block_vars("sel", array("option" => $value[$x],"id" => $value[$y]));
        }
        // Affichage du gabarit
        $gab->pparse("body");
    }

    /* Fonction affichage de connexion */
    public function connexion(){
      // Création nouveau template
      $gab = new Template(";/");
      $gab -> set_filenames(array("body"=>"profil.tpl.html"));
      // Si la requête possède au moins un résultat
      if (!empty($this->data)) {
        // Pour chaque ligne de résultats (de la requête)
        foreach ($this->data as $dino){
          // Remplissage des cases
          $gab->assign_vars(array("pseudo"=>$dino["pseudo"]));
          $gab->assign_vars(array("prenom"=>$dino["prenom"]));
          $gab->assign_vars(array("mail"=>$dino["mail"]));
          // Remplissage des informations de session
          $_SESSION["pseudo"] = $dino["pseudo"];
          $_SESSION["prenom"] = $dino["prenom"];
        }
      // Affichage du gabarit
      $gab->pparse("body");
      }
      // Si la requête est vide
      else {
        // Formulaire de connexion
        include("connexion.html");
        // Erreur champs manquants
        include("connexion.erreur.html");
        // Inscription
        include("inscription.html");
      }
    }
  }

  /* Classe des objets Dino */
  class Dino{
    protected $pdo;
    protected $didi;
    protected $didi1;
    protected $didi2;
    protected $didi3;
    protected $didi4;
    protected $didi5;
    protected $didi6;
    public $data;
    public $x="";
    public $y="";

    /* Constructeur */
    function __construct($param_pdo){
      $this->pdo = $param_pdo;
      // Requête liste des espèces
      $this->didi = new Req($this->pdo, "Liste complète des espèces","SELECT dino.id_dino, dino.nom_dino, ssordre.sous_ordre, ordre.ordre, epoque.periode FROM dino INNER JOIN ssordre ON dino.id_ssordre=ssordre.id_ssordre INNER JOIN ordre ON ssordre.id_ordre=ordre.id_ordre INNER JOIN epoque ON dino.id_epoque=epoque.id_epoque");
    }

    /* Fonction caractéristiques fiche espèce */
    public function Dino1($id){
      // Requête affichage d'un dino en fonction de son id
      $didi = new Req($this->pdo, "Le dinosaure","SELECT dino.nom_dino, dino.img_dino, ssordre.sous_ordre, ordre.ordre, epoque.periode, locomotion.mode_locomotion, milieu.milieu_vie, regime.regime_alim, reproduction.repro FROM dino INNER JOIN ssordre ON dino.id_ssordre=ssordre.id_ssordre INNER JOIN ordre ON ssordre.id_ordre=ordre.id_ordre INNER JOIN epoque ON dino.id_epoque=epoque.id_epoque INNER JOIN locomotion ON dino.id_locomotion=locomotion.id_locomotion INNER JOIN milieu ON dino.id_milieu=milieu.id_milieu INNER JOIN regime ON dino.id_regime=regime.id_regime INNER JOIN reproduction ON dino.id_reproduction=reproduction.id_reproduction WHERE id_dino= $id");
      // Exécution
      $didi->executer();
      // Affichage
      $didi->Dinofiche();
    }

    /* Fonction listes déroulantes pour la recherche */
    public function Dino2(){
      // Requête période géologique
      $didi2= new Req($this->pdo, "Période","SELECT DISTINCT id_epoque, periode FROM epoque ORDER BY periode ASC");
      // Exécution de la requête
      $didi2->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste1()
      $x="periode";
      $y="id_epoque";
      $didi2->liste1($x, $y) ;
      // Requête milieu de vie
      $didi= new Req($this->pdo, "Milieu de vie","SELECT DISTINCT id_milieu, milieu_vie FROM milieu ORDER BY milieu_vie ASC");
      // Exécution de la requête
      $didi->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste1()
      $x="milieu_vie";
      $y="id_milieu";
      $didi->liste1($x, $y) ;
      // Requête mode de locomotion
      $didi2= new Req($this->pdo, "Mode de locomotion","SELECT DISTINCT id_locomotion, mode_locomotion FROM locomotion ORDER BY mode_locomotion ASC");
      // Exécution de la requête
      $didi2->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste1()
      $x="mode_locomotion";
      $y="id_locomotion";
      $didi2->liste1($x, $y) ;
      // Requête mode de reproduction
      $didi3= new Req($this->pdo, "Mode de reproduction","SELECT DISTINCT id_reproduction, repro FROM reproduction ORDER BY repro ASC");
      // Exécution de la requête
      $didi3->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste1()
      $x="repro";
      $y="id_reproduction";
      $didi3->liste1($x, $y) ;
      // Requête régime alimentaire
      $didi4= new Req($this->pdo, "Régime alimentaire","SELECT DISTINCT id_regime, regime_alim FROM regime ORDER BY regime_alim ASC");
      // Exécution de la requête
      $didi4->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste1()
      $x="regime_alim";
      $y="id_regime";
      $didi4->liste1($x, $y);
    }

    /* Fonction listes déroulantes des caractéristiques pour ajout d'une nouvelle espèce */
    public function Dino3(){
      // Requête sous-ordre
      $didi = new Req($this->pdo, "Sous-ordre", "SELECT DISTINCT id_ssordre, sous_ordre FROM ssordre ORDER BY sous_ordre ASC");
      // Exécution de la requête
      $didi->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste2()
      $x="sous_ordre";
      $y="id_ssordre";
      $didi->liste2($x, $y);
      // Requête période géologique
      $didi2= new Req($this->pdo, "Période","SELECT DISTINCT id_epoque, periode FROM epoque ORDER BY periode ASC");
      // Exécution de la requête
      $didi2->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste2()
      $x="periode";
      $y="id_epoque";
      $didi2->liste2($x, $y) ;
      // Requête milieu de vie
      $didi3= new Req($this->pdo, "Milieu de vie","SELECT DISTINCT id_milieu, milieu_vie FROM milieu ORDER BY milieu_vie ASC");
      // Exécution de la requête
      $didi3->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste2()
      $x="milieu_vie";
      $y="id_milieu";
      $didi3->liste2($x, $y) ;
      // Requête mode de locomotion
      $didi4= new Req($this->pdo, "Mode de locomotion","SELECT DISTINCT id_locomotion, mode_locomotion FROM locomotion ORDER BY mode_locomotion ASC");
      // Exécution de la requête
      $didi4->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste2()
      $x="mode_locomotion";
      $y="id_locomotion";
      $didi4->liste2($x, $y) ;
      // Requête mode de reproduction
      $didi5= new Req($this->pdo, "Mode de reproduction","SELECT DISTINCT id_reproduction, repro FROM reproduction ORDER BY repro ASC");
      // Exécution de la requête
      $didi5->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste2()
      $x="repro";
      $y="id_reproduction";
      $didi5->liste2($x, $y) ;
      // Requête régime alimentaire
      $didi6= new Req($this->pdo, "Régime alimentaire","SELECT DISTINCT id_regime, regime_alim FROM regime ORDER BY regime_alim ASC");
      // Exécution de la requête
      $didi6->executer();
      // Initialisation des paramètres x (nom) et y (id) pour la fonction liste2()
      $x="regime_alim";
      $y="id_regime";
      $didi6->liste2($x, $y);
    }

    /* Fonction d'insertion d'une espèce à la base */
    public function Dino4($espece, $ssordre, $epoque, $milieu, $locomotion, $reproduction, $regime, $image){
      // Requête d'insertion
      $res = $this->pdo->prepare("INSERT INTO dino (nom_dino, img_dino, id_ssordre, id_epoque, id_milieu, id_regime, id_locomotion, id_reproduction) VALUES (?,?,?,?,?,?,?,?)");
      // Exécution de la requête
      $res->execute([$espece, $image, $ssordre, $epoque, $milieu , $locomotion, $reproduction, $regime]);
    }

    /* Fonction de recherche d'espèces */
    public function Dino5($periode, $milieu, $locomotion, $reproduction, $regime){
      // Requête de recherche
      $didi = new Req($this->pdo, "Espèces correspondantes", 'SELECT dino.id_dino, dino.nom_dino, ssordre.sous_ordre, ordre.ordre, epoque.periode FROM dino INNER JOIN ssordre ON dino.id_ssordre=ssordre.id_ssordre INNER JOIN ordre ON ssordre.id_ordre=ordre.id_ordre INNER JOIN epoque ON dino.id_epoque=epoque.id_epoque WHERE dino.id_epoque LIKE "'.$periode.'" AND dino.id_milieu LIKE "'.$milieu.'" AND dino.id_locomotion LIKE "'.$locomotion.'" AND dino.id_reproduction LIKE "'.$reproduction.'" AND dino.id_regime LIKE "'.$regime.'"');
      // Exécution de la requête
      $didi->executer();
      // Affichage des résultats
      $didi->afficherTab();
    }

    /* Fonction de recherche de l'espèce ajoutée */
    public function Dino6($nom){
      // Requête de recherche
      $didi = new Req($this->pdo, "Espèce ajoutée", 'SELECT dino.nom_dino, dino.img_dino, ssordre.sous_ordre, ordre.ordre, epoque.periode, locomotion.mode_locomotion, milieu.milieu_vie, regime.regime_alim, reproduction.repro FROM dino INNER JOIN ssordre ON dino.id_ssordre=ssordre.id_ssordre INNER JOIN ordre ON ssordre.id_ordre=ordre.id_ordre INNER JOIN epoque ON dino.id_epoque=epoque.id_epoque INNER JOIN locomotion ON dino.id_locomotion=locomotion.id_locomotion INNER JOIN milieu ON dino.id_milieu=milieu.id_milieu INNER JOIN regime ON dino.id_regime=regime.id_regime INNER JOIN reproduction ON dino.id_reproduction=reproduction.id_reproduction WHERE dino.nom_dino LIKE "'.$nom.'"');
      // Exécution de la requête
      $didi->executer();
      // Affichage du résultat
      $didi->Dinofiche();
    }

    /* Fonction d'affichage de toutes les espèces */
    public function tablo(){
      $this->didi->executer();
      $this->didi->afficherTab();
    }

    /* Fonction de connexion */
    public function Connect($mail, $mdp){
      // Requête de recherche de l'utilisateur
      $didi = new Req($this->pdo, "Connexion", 'SELECT prenom, pseudo, mail FROM user WHERE mail LIKE "'.$mail.'" AND mdp LIKE "'.$mdp.'"');
      // Exécution de la requête
      $didi->executer();
      // Remplissage des informations de session
      $_SESSION["mail"] = $mail;
      $_SESSION["mdp"] = $mdp;
      // Fonction affichage de connexion
      $didi->connexion();
    }

    /* Fonction d'inscription */
    public function Sign($prenom, $pseudo, $mail, $mdp){
      // Requête d'insertion
      $res = $this->pdo->prepare("INSERT INTO user (pseudo, prenom, mail, mdp) VALUES (?,?,?,?)");
      // Exécution de la requête
      $res->execute([$prenom, $pseudo, $mail, $mdp]);
    }

  }
 ?>
