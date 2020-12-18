<?php
    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&!empty($_POST['mail'])&&!empty($_POST['pwd'])&&!empty($_POST['cpwd'])){
        if($_POST['pwd']===$_POST['cpwd']){
            $database = new PDO('mysql:host=localhost;dbname=achatenligne','root','');
            $nom=$_POST['nom'];
            $prenom=$_POST['prenom'];
            $email=$_POST['mail'];
            $pwd=$_POST['pwd'];

            $client = $database->prepare('INSERT INTO connexions(nom, prenom, email, mdp) VALUES(:nom, :prenom, :email, :mdp)');
            $client ->execute(array(
                'nom'=>$nom,
                'prenom'=>$prenom,
                'email'=>$email,
                'mdp'=>$pwd
            ));
            header('Location:http://localhost/achatenligne/connexion.html');
            
        }else{
            header('Location:http://localhost/achatenligne/enregistrement.html');
    exit();
        }
        

    }else{
       
    header('Location:http://localhost/achatenligne/enregistrement.html');
    exit();

    }
?>