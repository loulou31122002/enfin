<?php 

//Gérer les voitures

//ajout

function ajouter($modèle,$image,$description,$prix){

  if(require("connexion.php")){
    

     $req = $access->prepare("INSERT INTO voiture VALUES
      ('', ?, ? , ? , ?) ");

     $req -> execute(array($modèle,$image,$description,$prix));
     
     $req->closeCursor();
  } 
}


//affichage

function afficher(){ 
    if(require("connexion.php")){

    $req = $access->prepare("SELECT * FROM voiture");

    $req -> execute();

    $data = $req->fetchAll(PDO::FETCH_OBJ);

    return $data;

    $req->closeCursor();
}


}
 
//rechercher 1 voit
function rechercherVoiture($idv){
  if (require("connexion.php")) {
    $req = $access->prepare("SELECT * FROM voiture WHERE idv=?");
    $req->execute(array($idv));
    return $req->fetch(PDO::FETCH_ASSOC);
} else {
    return false; 
}
}


//suppression 

function supprimer($idv){
    if(require("connexion.php")){
    
        $req=$access->prepare("DELETE FROM voiture WHERE idv=?");

        $req->execute(array($idv));
    }
} 


//Gérer les réservations 
function ajouterR($Date_de_Départ,$Date_de_fin,$Mode_de_Paiement,$idv){

  if(require("connexion.php")){
    

     $req = $access->prepare("INSERT INTO reservation VALUES
      ('', ?, ? , ? , ?) ");

     $req->execute(array($Date_de_Départ, $Date_de_fin, $Mode_de_Paiement, $idv));
     
     $req->closeCursor();
  } 
}





//Gérer les clients


function ajouterclient($nom,$prenom,$mail,$mdp){

    if(require("connexion.php")){
  
       $req = $access->prepare("INSERT INTO client  VALUES ('', ?, ? , ? , ?)");
       $req -> execute(array($nom,$prenom,$mail,$mdp));
       
       return true;
       $req->closeCursor();
    } 
  }

  function Seconnecter($email, $motdepasse){
  
    if(require("connexion.php")){
  
      $req = $access->prepare("SELECT * FROM client WHERE mail= ? AND mdp= ?");
  
      $req->execute(array($email, $motdepasse));

      if($req->rowCount() == 1){
        
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        var_dump(($data));
        foreach($data as $i){
          $mail = $i->mail;
          $mdp = $i->mdp;
        }
  
        if($mail == $email AND $mdp == $motdepasse)
        {
          return $data;
        }
        else{
            return false;
        }
  
      }
  
    }
  
  }
  function afficher1(){ 
    if(require("connexion.php")){

    $req = $access->prepare("SELECT * FROM client");

    $req -> execute();

    $data1 = $req->fetchAll(PDO::FETCH_OBJ);

    return $data1;

    $req->closeCursor();
}


}


function supprimer1($idc){
    if(require("connexion.php")){
    
        $req=$access->prepare("DELETE FROM client WHERE idc=?");

        $req->execute(array($idc));
    }
}

function addToP($id){
  $_SESSION['panier'][] = $id;
}






?>