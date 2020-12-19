<?php
/******Connexion base  */
    $database = new PDO('mysql:host=localhost;dbname=achatenligne','root','');

    $result = $database->prepare('SELECT genrehumain.genre as genre, vetement.styleVetement AS vetement,taille.categorieTaille AS taille,couleur.nomCouleur AS couleur,stock.prixUnitaire AS prix,stock.quantite AS quantite FROM stock,genrehumain,vetement,taille,couleur
    WHERE genrehumain.id=stock.genre
    and stock.typeVetement = vetement.idVetement
    AND stock.taille = taille.idTaille
    AND stock.couleur = couleur.idCouleur
    ORDER BY stock.id');
    $executeIsOk = $result ->execute();

    $stocks = $result->fetchAll();
    /**********genre */
    $genre = $database->prepare('SELECT * FROM genrehumain');
    $executeIsOk = $genre ->execute();

    $stocksG = $genre->fetchAll();
    /************************vetement */
    $vetement = $database->prepare('SELECT * FROM vetement');
    $executeIsOk = $vetement ->execute();

    $stocksV = $vetement->fetchAll();
    /************************taille */
    $taille = $database->prepare('SELECT * FROM taille');
    $executeIsOk = $taille ->execute();

    $stocksT = $taille->fetchAll();
    /*******************couleur */
    $couleur = $database->prepare('SELECT * FROM couleur');
    $executeIsOk = $couleur ->execute();

    $stocksC = $couleur->fetchAll();
    /*****client */
    $connexion = $database->prepare('SELECT * FROM connexions');
    $executeIsOk = $connexion ->execute();

    $connexions = $connexion ->fetchAll();

    /**********test connexion */
    

    if(isset($_POST['mail'])&&isset($_POST['pwd'])){
        
    foreach($connexions as $conn):
        if(($_POST['mail']==$conn['email'])&&($_POST['pwd']==$conn['mdp'])){
            header('Location:http://localhost/achatenligne/achatenligne1.0/connexion.php');
        }else{
            echo 'houston we have a problem';
            echo $_POST['mail'];
            echo $_POST['pwd'];
        /*header('Location:http://localhost/achatenligne/connexion.html');*/
        }
    endforeach;
    }else{
        echo 'houston we have a problem!!!!!!!!!!!';
        echo var_dump($email);
    }
?>

<!-- Parti HTML-->
<!DOCTYPE HTML>
<html>
    <head>
        
    </head>
    <body>
        <h1>Stock de la Boutique</h1>
        <em>Faites votre choix puis Enregistrer votre achat:</em><br>
        <form method="POST" action="" >
            <label for="genre">Genre: </label>
                
                <select name="genre" id="genre">
                    <option value="">----------</option>
                    <?php foreach ($stocksG as $stockG): ?>
                    <option value=<?= $stockG['id'] ?>><?= $stockG['genre'] ?></option>
                    <?php endforeach;?>           
                </select><br>
                
            
                <label for="vetement">Type de vetement</label>
                <select name="vetement" id="vetement">
                    <option value="">----------</option>
                    <?php foreach ($stocksV as $stockV): ?>
                    <option value=<?= $stockV['idVetement'] ?>><?= $stockV['styleVetement'] ?></option>
                    <?php endforeach;?>           
                </select><br>
                

                <label for="taille">Taille</label>
                <select name="taille" id="taille">
                <option value="">----------</option>
                    <?php foreach ($stocksT as $stockT): ?>
                    <option value=<?= $stockT['idTaille'] ?>><?= $stockT['categorieTaille'] ?></option>
                    <?php endforeach;?>          
                </select><br>
                <label for="couleur">Couleur</label>
            
            <select name="couleur" id="couleur">
            <option value="">----------</option>
                <?php foreach ($stocksC as $stockC): ?>
                <option value=<?= $stockC['idCouleur'] ?>><?= $stockC['nomCouleur'] ?></option>
                <?php endforeach;?>          
            </select><br>
            <label for="qte">Quantité: </label>
                
                <select name="qte" id="qte">
                <?php for ($i = 0; $i <= 10; $i++) {
                   echo "<option value='".$i."'>".$i."</option>";
                };       
                ?>
                            
                </select><br>
                
                
                    <label name="consultation">Consulation:</label>
                    <input type="radio" id="consultation" name="choix" /> 

                    <label name="achat">Achat:</label>
                    <input type="radio" id="achat" name="achat" />

                    <input type="submit" value="Envoi">
                </form>
        <?php
        if(isset($_POST['genre'])&&isset($_POST['vetement'])&&isset($_POST['taille'])&&isset($_POST['couleur'])&&isset($_POST['qte'])&&isset($_POST['achat'])){
            echo $_POST['genre']."<br>";
            echo $_POST['vetement']."<br>";
            echo $_POST['taille']."<br>";
            echo $_POST['couleur']."<br>";
            echo $_POST['qte']."<br>";
        $stockss = $database->prepare('SELECT * FROM `stock` WHERE genre='.$_POST['genre'].' AND typeVetement='.$_POST['vetement'].' AND taille='.$_POST['taille'].' AND couleur='.$_POST['couleur']);
            $executeIsOk = $stockss ->execute();
        
            $stocksss = $stockss->fetchAll();
            ?>

            <?php foreach ($stocksss as $zak): ?>
                
                   
                    <?php
                    echo $zak['id'];
                        $p=intval($_POST['qte']);
                        $z=intval($zak['id']);
                        echo $p;
                        echo $z;
                        var_dump($z);
                       $quant = $database->prepare("UPDATE stock set quantite=(quantite-$p) WHERE id=$z");
                        $executeIsOk = $quant->execute();
                    ?>
            <?php endforeach;?>

        <?php }; ?>

        <?php
        if(isset($_POST['choix'])){
        ?>            
           <table style='text-align: center'>
                   <tr>
                        <th>Genre</th>
                        <th>Type de vetement</th>
                        <th>Taille</th>
                        <th>Couleur</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>
                
                        <?php foreach ($stocks as $stock): ?>
                            <tr>
                                <td><?= $stock['genre'] ?></td>
                                <td><?= $stock['vetement'] ?></td>
                                <td><?= $stock['taille'] ?></td>
                                <td><?= $stock['couleur'] ?></td>
                                <td><?= $stock['prix'] ?></td>
                                <td><?= $stock['quantite'] ?></td>
                            </tr>
                        <?php endforeach;?>
                    
                    
            

            </table>
                        <?php }; ?>
                  
                        
    </body>

</html>