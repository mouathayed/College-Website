<?php
include "config.php";
include "authentication.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['email'];
    $newnom = $_POST['value1'];
    $newprenom = $_POST['value2'];
    $newmail = $_POST['value3'];
    $newcode = $_POST['value4'];

    $stmt = $pdo->prepare("UPDATE utilisateur SET Nom=:nom, Prénom=:prenom, Email=:email, Mdp=:code,User_role='etudiant' WHERE Email=:mail");
    $stmt->bindParam(':nom', $newnom);
    $stmt->bindParam(':prenom', $newprenom);
    $stmt->bindParam(':email', $newmail);
    $stmt->bindParam(':code', $newcode);
    $stmt->bindParam(':mail', $mail);
    if ($stmt->execute()) {
        header("Location: etudiantadmin.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->errorInfo()[2];
    }
    header("Location: etudiantadmin.php");
}
