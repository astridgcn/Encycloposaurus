<?php
  class Requete {
    protected $pdo;
    protected $nom;
    protected $req;
    protected $data;

    /* Constructeur */
    function __construct($param_pdo, $param_nom, $param_req){
      $this->pdo = $param_pdo;
      $this->nom = $param_nom;
      $this->req = $param_req;
    }

    /* Execution des requêtes "Req" */
    public function executer(){
      $res = $this->pdo->prepare($this->req);
      $res->execute();
      $this->data = $res->fetchAll(PDO::FETCH_ASSOC);
    }
  }
 ?>
