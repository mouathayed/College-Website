<?php
include "authentication.php";
include "config.php";

// Check if the form was submitted
    // Extract the values of the input fields
    $id_user = $_POST['studentId'];
    $id_matiere = $_POST['matiereId'];
    $examen = $_POST['value1'];

    $controle = $_POST['value2'];
    $sql = "UPDATE note SET note_exam =:examen, note_ds =:controle WHERE Id_user = :id_user and Id_matiere=:id_matiere";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['examen' => $examen, 'controle' => $controle, 'id_user' => $id_user,'id_matiere' => $id_matiere]);
header("Location: affichaget.php");
    if ($stmt) {

        exit;
    } else {
        echo "Error updating record: " . $pdo->errorInfo();
    }
    echo $id_user;
    echo $id_matiere;
    echo $examen;
    echo $controle;
   ## header("Location: enseignant.php");

?>