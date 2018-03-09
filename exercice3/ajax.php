<?php
require_once 'connect.php';

if(isset($_POST['action']) && $_POST['action']=='affiche'){  //je recois la requete ajax pour afficher les vehicule
    $sql = "SELECT * FROM vehicule";
    $req = $db->prepare($sql);
    $req->execute();
    $tab['vehicules']=$req->fetchAll(PDO::FETCH_ASSOC);
    $tab['resultat']=false;
    if(count($tab['vehicules'])>0){
        $tab['resultat']=true;
    }
    echo json_encode($tab);
}


if(isset($_POST['action']) && $_POST['action']=='insert'){  //je recois la requete ajax pour inserer un véhicule

    //j'écris ma requete sql
    $sql = "INSERT INTO vehicule (marque, modele, annee, couleur) VALUES(:marque,:modele,:annee,:couleur)";
    $insertVehicule = $db->prepare($sql);
    $params = array(
        'marque' => $_POST['marque'],
        'modele' => $_POST['modele'],
        'annee' => $_POST['annee'],
        'couleur' => $_POST['couleur']
    );
    $tab['resultat']=false;
    if($insertVehicule->execute($params)===true){
        //insert réussit
        $tab['resultat']=true;
    }
    echo json_encode($tab);
}
