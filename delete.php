<?php
// On démarre une session
session_start();

// Est-ce que l'id_equipage existe et n'est pas vide dans l'url
if(isset($_GET['id_equipage']) && !empty($_GET['id_equipage'])){
    require_once('connect.php');

    // On nettoie l'id_equipage envoyé
    $id = strip_tags($_GET['id_equipage']);

    $sql = 'SELECT * FROM `equipage` WHERE `id_equipage` = :id_equipage;';

    // On prépare la requête
    $query = $bdd->prepare($sql);

    // On "accroche" les paramètres (id_equipage)
    $query->bindValue(':id_equipage', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le membre
    $membres = $query->fetch();

    // On vérifie si le membre existe
    if(!$membres){
        $_SESSION['erreur'] = "Cet id_equipage n'existe pas";
        header('Location: index.php');
        die();
    }

    $sql = 'DELETE FROM `equipage` WHERE `id_equipage` = :id_equipage;';

    // On prépare la requête
    $query = $bdd->prepare($sql);

    // On "accroche" les paramètres (id_equipage)
    $query->bindValue(':id_equipage', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    $_SESSION['message'] = "Membre supprimé";
    header('Location: index.php');

}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>