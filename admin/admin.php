<?php
session_start();
include "config.php";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 3;
$offset = ($page - 1) * $limit;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Africa/tunis");
$sql2 = "SELECT nom_enseignant, prenom_enseignant, email, mot_de_passe FROM enseignant LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql2);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
$sql_count = "SELECT COUNT(*) AS count FROM enseignant";
$stmt = $pdo->query($sql_count);
$rowwww = $stmt->fetch();
$total_pages = ceil((int)$rowwww['count'] / $limit);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EPI administration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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

                        <a href="enseignantadmin.php" class="btn btn-danger btn-rounded""><i class="fa fa-university" aria-hidden="true"></i> <span>enseignants</span></a>
                        <a href="etudiantadmin.php" class="btn btn-danger btn-rounded""><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>étudiants</span></a>

                    </div>
                </div>
                <div style="height: 20px;"></div><div style="height: 20px;"></div>
                <div class="row">

                    <div class="col-sm-6">
                        <h2>Liste <b>des étudiants</b></h2>
                    </div>

                    <div class="col-sm-6">
                        <a href="#addetudiant" class="btn btn-info add-new" data-toggle="modal"><i
                                class="material-icons">&#xE147;</i> <span>Ajouter un etudiant</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>email</th>
                    <th>mot de passe</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                    <td><?php echo htmlspecialchars($row["nom_enseignant"]); ?></td>
                    <td><?php echo htmlspecialchars($row["prenom_enseignant"]); ?></td>
                    <td><?php echo htmlspecialchars($row["email"]); ?></td>
                    <td><?php echo htmlspecialchars($row["mot_de_passe"]); ?></td>
                    <td>
                        <a href="javascript:void(0);" class="edit" data-toggle="modal" data-target="#editetudiant"
                           data-email="<?php echo $row["email"]; ?>"><i class="material-icons"
                                                                        data-toggle="tooltip"
                                                                        title="Editer">&#xE254;</i></a>


                        <a href="deleteetudiant.php?email=<?php echo $row["email"]; ?>" onclick="return confirm('Êtes-vous sûr de bien vouloir supprimer cette étudiant?');" class="delete"><i class="material-icons" data-toggle="tooltip" title="supprimer">&#xE872;</i></a>


                    </td>
                    </tr><?php } ?>

                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">affichage <b><?php echo $limit ?></b> de <b><?php echo $rowwww[0] ?></b>
                    étudiants
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
<div id="addetudiant" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un etudiant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>email</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>mot de passe</label>
                        <input type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                    <input type="submit" class="btn btn-success" value="Ajouter">
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editetudiant" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="editetudiant.php" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Editer étudiant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="emaill" name="emaill">
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" class="form-control" id="newnom" name="newnom"  required>
                    </div>
                    <div class="form-group">
                        <label>prénom</label>
                        <input type="text" class="form-control" id="newprenom" name="newprenom"  required>
                    </div>
                    <div class="form-group">
                        <label>email</label>
                        <input type="email" class="form-control" id="newmail" name="newmail"  required>
                    </div>
                    <div class="form-group">
                        <label>mot de passe</label>
                        <input type="text" class="form-control" id="newcode" name="newcode"  required>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                    <input type="submit" class="btn btn-info" value="Sauvegarder">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#editetudiant').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var modal = $(this);
        modal.find('#newmail').val(button.data('email')); // Set the value of the email input field
        modal.find('#emaill').val(button.data('email')); // Set the value of the hidden input field
    });
</script>
</body>
</html>