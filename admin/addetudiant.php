<?php
include "config.php";
//include "authentication.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    try {
        $stmt = $pdo->prepare("INSERT INTO utilisateur (Nom,Prénom,Mdp, Email,User_role ) VALUES (:nom, :prenom, :pass, :email, 'etudiant')");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);

        $stmt->execute();

        header("Location: etudiantadmin.php");
        exit;

    } catch (PDOException $e) {
        echo "Error adding record: " . $e->getMessage();
    }
}
