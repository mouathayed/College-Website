<?php
session_start();
include "config.php";
$id_matiere = $_GET['id'];
$sql = "SELECT DISTINCT id_user, email, Nom, prénom FROM utilisateur u WHERE u.user_role = 'etudiant' AND u.id_user NOT IN ( SELECT n.id_user FROM note n WHERE n.id_matiere =:id )";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id_matiere]);
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
                    <div class="col-sm-6">
                        <h2>Ajout <b>au matiere</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Ajouter</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr class="student" data-user-id="<?php echo $row["id_user"]; ?>">
                        <td><?php echo $row["Nom"]; ?></td>
                        <td><?php echo $row["prénom"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td>
                            <button class="edit-button btn btn-transparent" data-user-id="<?php echo $row["id_user"]; ?>" data-matiere-id="<?php echo $id_matiere; ?>" data-toggle="tooltip" title="Editer">
                                <i class="material-icons text-primary">add</i>
                            </button>
                        </td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="my-div"></div>
    <form action="logout.php" method="POST">
        <button type="submit" name="logout" class="btn btn-primary">Logout</button>
    </form>
    <form action="matieres.php">
        <button type="submit" class="btn btn-primary">Turn Back</button>
    </form>
</div>

</body>
<script>
    $(document).ready(function() {
        // Handle click event on edit buttons
        $('.edit-button').click(function() {
            var userId = $(this).data('user-id');
            var matiereId = $(this).data('matiere-id');

            // Make an AJAX request to inscrie.php
            $.ajax({
                url: 'inscrie.php',
                method: 'POST',
                data: { 'user-id': userId, 'matiere-id': matiereId },
                success: function(response) {
                    // Handle the response from inscrie.php if needed
                    console.log(response);
                    location.href = location.href;
                },
                error: function(xhr, status, error) {
                    // Handle any errors that occur during the AJAX request
                    console.log(error);
                }
            });
        });
    });
</script>



</html>
