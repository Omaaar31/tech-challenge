<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id_equipage']) && !empty($_GET['id_equipage'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id_equipage']);

    $sql = 'SELECT * FROM `equipage` WHERE `id_equipage` = :id_equipage;';

    // On prépare la requête
    $query = $bdd->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id_equipage', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le membre
    $membres = $query->fetch();

    // On vérifie si le membre existe
    if(!$membres){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails des membres <?= $membres['id_equipage'] ?></h1>
                <p>ID : <?= $membres ['id_equipage'] ?></p>
                <p>Nom : <?= $membres ['nom_equipage'] ?></p>
                <p><a href="index.php">Retour</p>
            </section>
        </div>
    </main>
</body>
</html>