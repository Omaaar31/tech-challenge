<?php

session_start();
require_once('connect.php');


if($_POST){
    // Est-ce que le nom_equipage reçu existe et n'est pas vide 
    if(isset($_POST['nom_equipage']) && !empty($_POST['nom_equipage'])){
    
        require_once('connect.php');

        // On nettoie les données envoyées
        $name = strip_tags($_POST['nom_equipage']);

        $sql = 'INSERT INTO `equipage` (`nom_equipage`) VALUES (:nom_equipage);';

        // On prépare la requête
        $query = $bdd->prepare($sql);

        // On "accroche" les paramètres (nom_equipage)
        $query->bindValue(':nom_equipage', $name, PDO::PARAM_STR);
       
        // On exécute la requête    
        $query->execute();

        // On affiche un message quand le membre est ajouté
        $_SESSION['message'] = "Membre de l'équipage ajouté";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

$sql = 'SELECT * FROM `equipage`'; 

// On prépare la requête
$query = $bdd->prepare($sql);

// On exécute la requête 
$query->execute();

// On stock le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');

?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Argonautes</title>
            <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<!-- Header section -->
<header>
  <h1>
    <img src="https://www.wildcodeschool.com/assets/logo_main-e4f3f744c8e717f1b7df3858dce55a86c63d4766d5d9a7f454250145f097c2fe.png" alt="Wild Code School logo" />
    Les Argonautes
  </h1>
</header>

<!-- Main section -->
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                if(!empty($_SESSION['message'])){
                    echo '<div class="alert alert-success" role="alert">
                            '. $_SESSION['message'].'
                        </div>';
                    $_SESSION['message'] = "";
                }
                ?>
                
                <h2>Ajouter un(e) Argonaute</h2>
                    <form class="new-member-form" method="post">
                        <label for="nom_equipage">Nom de l&apos;Argonaute</label> <br>
                            <input id="name" name="nom_equipage" type="text" placeholder="Charalampos" />
                                <button type="submit">Envoyer</button>
                    </form>

                  <!-- Member list -->
                <h2>Membres de l'équipage</h2>
                    <table class="table">
                        <thead>
                            <th>Nom</th>
                            <th>Plus</th>
                        </thead>
                        <tbody>
                            <?php
                                // On boucle sur la variable result
                                foreach ($result as $membres){
                            ?>
                                <tr>
                                    <td><?= $membres ['nom_equipage'] ?></td>
                                    <td><a href="details.php?id_equipage=<?=$membres['id_equipage']?>">Voir détail</a> <a href="delete.php?id_equipage=<?= $membres['id_equipage'] ?>">Supprimer</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
        </div>

        <footer>
            <p>Réalisé par Jason en Anthestérion de l'an 515 avant JC</p>
        </footer>
    </body>
</html>