<?php
include "config.php";
//include "authentication.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $nom_matiere=$_POST['matiere'];

    try {
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, Prénom, Email, Mdp, User_role) VALUES (:nom, :prenom, :email, :pass, 'enseignant')");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();

        $last_id = $pdo->lastInsertId();
        $stmt2 = $pdo->prepare("INSERT INTO matiere (id_user, nom_matiere) VALUES (:id, :nom_matiere)");
        $stmt2->bindParam(':id', $last_id);
        $stmt2->bindParam(':nom_matiere', $nom_matiere);
        $stmt2->execute();

        header("Location: enseignantadmin.php");
        exit;
    } catch (PDOException $e) {
        echo "Error adding record: " . $e->getMessage();
    }
}
?>
