<?php
session_start();
include "config.php";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 9;
$offset = ($page - 1) * $limit;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Africa/tunis");
$storedUsername = $_SESSION['username'];
$sql1="select * from Utilisateur where Email=:storedUsername";
$result1=$pdo->prepare($sql1);
$result1->execute(['storedUsername'=>$storedUsername]);
$row = $result1->fetch(PDO::FETCH_ASSOC);
$id_user =intval($row['Id_user']) ;
$sql2 = "select nom_matiere,note_ds,note_exam from matiere as m ,note as n 
where m.Id_matiere = n.Id_matiere and n.Id_user=:id_user
 ORDER BY nom_matiere ASC LIMIT $limit OFFSET $offset";
$result2 = $pdo->prepare($sql2);
$result2->execute(['id_user' => $id_user]);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EPI administration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Liste <b>de notes</b></h2>
                    </div>

                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nom de matière</th>
                    <th>examen</th>
                    <th>controle continu</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result2->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                    <?php   echo "<td>" . $row["nom_matiere"] . "</td>";
                    echo "<td>" . $row["note_exam"] . "</td>";
                    echo "<td>" . $row["note_ds"] . "</td>";?>
                    </tr><?php } ?>

                </tbody>
            </table>
        </div>
    </div>
            <div class="my-div"></div>
            <form action="logout.php" method="POST">
                <button type="submit" name="logout" class="btn btn-primary">Logout</button>
            </form>
</body>
</html>