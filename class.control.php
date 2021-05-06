<?php

Class Appli {
  /* Fonction moteur */
  public function moteur($dino){
    // Si suivant contient une directive
    if (isset($_GET["suivant"])){
      $action=$_GET["suivant"];
    }
    // Sinon
    else{
      $action ="";
    }
    switch($action){

      /* Exécution de l'ajout */
      case "ajouter":
        // Vérification du remplissage des champs obligatoires
        if (!empty($_POST["nom_dino"]) AND !empty($_POST["id_ssordre"]) AND !empty($_POST["id_epoque"]) AND !empty($_POST["id_milieu"]) AND !empty($_POST["id_reproduction"]) AND !empty($_POST["id_regime"])) {
          // Si présence d'une image
          if (isset($_FILES['nom_du_fichier']['name']) AND ($_FILES['nom_du_fichier']['error'] == UPLOAD_ERR_OK)) {
            // Transfert de l'image vers le dossier
            $chemin_destination = 'images/dino/';
    				move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);
            // Requête d'ajout avec image de l'utilisateur
            $dino->Dino4($_POST["nom_dino"], $_POST["id_ssordre"], $_POST["id_epoque"], $_POST["id_milieu"], $_POST["id_locomotion"], $_POST["id_reproduction"], $_POST["id_regime"], $_FILES['nom_du_fichier']['name']);
          }
          else {
            // Requête d'ajout avec image par défaut
            $dino->Dino4($_POST["nom_dino"], $_POST["id_ssordre"], $_POST["id_epoque"], $_POST["id_milieu"], $_POST["id_locomotion"], $_POST["id_reproduction"], $_POST["id_regime"], "dinovierge.jpg");
          }
          // Affichage de la fiche
          $dino->Dino6($_POST["nom_dino"]);
          //Affichage du lien d'ajout
          include("index.ajout.php");
        }
        else {
          // Entête formulaire d'ajout
          include("ajout.entete.html");
          // Listes déroulantes des caractéristiques
          $dino->Dino3();
          // Fin du formulaire d'ajout
          include("ajout.pied.html");
          // Erreur champs obligatoires (tout sauf photo) manquants
          include("ajout.erreur.html");
        }
      break;

      /* Fiche espèce */
      case "fiche":
        // Affichage de la fiche de l'espèce cliquée
        $dino->Dino1($_GET["id"]);
        // Affichage de l'ajout
        include("index.ajout.php");
      break;

      /* Formulaire de recherche */
      case "recherche":
        // Entête du formulaire de recherche
        include("recherche.entete.html");
        // Listes déroulantes des caractéristiques
        $dino->Dino2();
        // Pied du formulaire de recherche
        include('recherche.pied.html');
      break;

      /* Exécution de la recherche */
      case "rechercher":
        // Entête affichage des résultats
        include("recherche.resultats.html");
        // Execution et affichage de la recherche
        $dino->Dino5($_POST["id_epoque"], $_POST["id_milieu"], $_POST["id_locomotion"], $_POST["id_reproduction"], $_POST["id_regime"]);
        // Redirection nouvelle recherche ou accueil
        include("recherche.redirection.html");
        // Affichage du lien d'ajout
        include("index.ajout.php");
      break;

      /* Page d'ajout */
      case "ajout":
        // Entête du formulaire d'ajout
        include("ajout.entete.html");
        // Listes déroulantes des caractéristiques
        $dino->Dino3();
        // Pied du formulaire d'ajout
        include("ajout.pied.html");
      break;

      /* Profil */
      case "profil":
        // Connexion (si pas connecté.e)
        if (!isset($_SESSION["pseudo"])){
          // Formulaire de connexion
          include("connexion.html");
          // Formulaire d'inscription
          include("inscription.html");
        }
        // Si connecté, page de profil
        if (isset($_SESSION["pseudo"])){
          // Affichage du profil
          include("profil.tpl.php");
        }
      break;

      /* Connexion */
      case "connexion":
        // Si champs bien remplis
        if (!empty($_POST["mail"]) AND !empty($_POST["mdp"])) {
          // Requête de connexion
         $dino->Connect($_POST["mail"], $_POST["mdp"]);
         // Affichage du profil
         header("Location: index.php?suivant=profil");
        }
        else {
          // Formulaire de connexion
          include("connexion.html");
          // Erreur champs manquants
          include("connexion.erreur.html");
          // Formulaire d'inscription
          include("inscription.html");
        }
      break;

      /* Déconnexion */
      case "deconnexion" :
        // Remise à 0 des champs de session
        $_SESSION=array();
        // Redirection vers le profil (pour se connecter ou s'inscrire)
        header("Location: index.php?suivant=profil");
      break;

      /* Inscription */
      case "inscription":
        // Si champs bien remplis
        if (!empty($_POST["prenom"]) AND !empty($_POST["pseudo"]) AND !empty($_POST["mail"]) AND !empty($_POST["mdp"]) AND !empty($_POST["mdp2"]) AND $_POST["mdp"] == $_POST["mdp2"]) {
          // Inscription
          $dino->Sign($_POST["prenom"], $_POST["pseudo"], $_POST["mail"], $_POST["mdp"]);
          // Requête de connexion
          $dino->Connect($_POST["mail"], $_POST["mdp"]);
          // Affichage du profil
          header("Location: index.php?suivant=profil");
        }
        else {
          // Erreur champs manquants
          include("inscription.erreur.html");
          // Formulaire d'inscription
          include("inscription.html");
        }
      break;

      /* Par défaut */
      default:
        // Affichage de l'accueil (introduction, diaporama)
        include("index.entete.html");
        // Affichage des espèces
        $dino->tablo();
        // Affichage du lien d'ajout
        include("index.ajout.php");
      break;
    }
  }
}
?>
