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
$sql2 = "SELECT u.Nom, u.Prénom,m.nom_matiere,m.Id_matiere FROM utilisateur as u ,matiere as m where User_role='enseignant' and u.Id_user=m.id_user LIMIT :limit OFFSET :offset";
$result2 = $pdo->prepare($sql2);
$limit = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$result2->bindParam(':limit', $limit, PDO::PARAM_INT);
$result2->bindParam(':offset', $offset, PDO::PARAM_INT);
$result2->execute();
$sql_count = "SELECT COUNT(*) AS count FROM matiere";
$result_count = $pdo->query($sql_count);
$rowwww = $result_count->fetch(PDO::FETCH_ASSOC);
$total_pages = ceil((int)$rowwww['count'] / $limit);

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
    <link rel="stylesheet" href="../css.css">
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
                    <div class="col-sm-8 text-center">

                        <a href="enseignantadmin.php" class="btn btn-danger btn-rounded""><i class="fa fa-university" aria-hidden="true"></i> <span>Enseignants</span></a>
                        <a href="etudiantadmin.php" class="btn btn-danger btn-rounded""><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>Étudiants</span></a>
                        <a href="matieres.php" class="btn btn-danger btn-rounded"><i class="fa fa-book" aria-hidden="true"></i><span>Matieres</span></a>

                    </div>
                </div>
                <div style="height: 20px;"></div><div style="height: 20px;"></div>
                <div class="row">

                    <div class="col-sm-6">
                        <h2>Liste <b>des Matieres</b></h2>
                    </div>

                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Matiere</th>
                    <th>Enseignant</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result2->fetch(PDO::FETCH_ASSOC)) { ?>

                <tr class="student" data-email="<?php echo $row["Id_matiere"]; ?>">
                    <?php echo "<td>" . $row["nom_matiere"] . "</td>";
                    echo "<td>" . $row["Prénom"] . '  '. $row["Nom"] . "</td>";
                    ?>
                    <td>
                        <a href="etudiantinscrit.php?id=<?php echo $row['Id_matiere']; ?>">
                            <i class="material-icons" data-toggle="tooltip" title="Editer">add</i>
                        </a>
                    </td>

                    </tr><?php } ?>

                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">affichage <b><?php echo $limit ?></b> de <b><?php echo $rowwww['count'] ?></b>
                    enseignant
                </div>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a href="?page=<?php echo($page - 1); ?>" class="page-link">Précédente</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled"><a href="#" class="page-link">Précédente</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $page): ?>
                            <li class="page-item active"><a href="#" class="page-link"><?php echo $i; ?></a></li>
                        <?php else: ?>
                            <li class="page-item"><a href="?page=<?php echo $i; ?>"
                                                     class="page-link"><?php echo $i; ?></a></li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a href="?page=<?php echo($page + 1); ?>" class="page-link">Suivante</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled"><a href="#" class="page-link">Suivante</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="my-div"></div>
    <form action="../logout.php" method="POST">
        <button type="submit" name="logout" class="btn btn-primary">Logout</button>
    </form>
</div>
</body>
</html>
