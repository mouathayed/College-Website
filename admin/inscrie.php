<?php
include "config.php";
//include "authentication.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $etudiant = $_POST['user-id']; // Updated the variable name
    $matiere = $_POST['matiere-id']; // Updated the variable name

    try {
        $stmt = $pdo->prepare("INSERT INTO note (id_user, id_matiere) VALUES (:id_etudiant, :id_matiere)");
        $stmt->bindParam(':id_etudiant', $etudiant);
        $stmt->bindParam(':id_matiere', $matiere);

        $stmt->execute();

        // Redirect to matiers.php
        header("Location: matieres.php");
        exit;
    } catch (PDOException $e) {
        echo "Error adding record: " . $e->getMessage();
    }

}
