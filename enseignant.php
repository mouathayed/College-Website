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
$sql1 = "SELECT * FROM utilisateur WHERE Email=:storedUsername";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute(['storedUsername' => $storedUsername]);
$r1 = $stmt1->fetch(PDO::FETCH_ASSOC);
$id_user = intval($r1['Id_user']);
$sql3 = "SELECT * FROM utilisateur as u ,matiere as m WHERE u.Id_user=m.id_user and m.id_user=:id_user";
$stmt3 = $pdo->prepare($sql3);
$stmt3->execute(['id_user' => $id_user]);
$r3 = $stmt3->fetch(PDO::FETCH_ASSOC);
$sql2 = "select u.nom,u.Prénom,n.note_exam,n.note_ds, n.Id_matiere,u.Id_user from utilisateur as u , matiere as m , note as n
where m.Id_matiere=n.id_matiere and n.id_user=u.Id_user and m.id_user=:id_user
LIMIT :limit OFFSET :offset";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(':id_user', $id_user, PDO::PARAM_INT);
$stmt2->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt2->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt2->execute();
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$sql_count = "SELECT COUNT(*) AS count FROM utilisateur as u , matiere as m , note as n
where m.Id_matiere=n.id_matiere and n.id_user=u.Id_user and m.id_user=:id_user";
$stmt_count = $pdo->prepare($sql_count);
$stmt_count->bindValue(':id_user', $id_user, PDO::PARAM_INT);
$stmt_count->execute();
$rowwww = $stmt_count->fetch(PDO::FETCH_ASSOC);
$total_pages = ceil((int)$rowwww['count'] / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Enseignant EPI </title>
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
                        <h2>Liste <b>des étudiants</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Note Exam</th>
                    <th>Note Ds</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result2 as $row) { ?>
                    <tr class="student" data-user-id="<?php echo $row["Id_user"]; ?>" data-matiere-id="<?php echo $row["Id_matiere"]; ?>">
                        <td><?php echo $row["nom"]; ?></td>
                        <td><?php echo $row["Prénom"]; ?></td>
                        <td><?php echo $row["note_exam"]; ?></td>
                        <td><?php echo $row["note_ds"]; ?></td>
                        <td>
                            <?php echo "<i class=\"material-icons text-primary\" data-toggle=\"tooltip\" title=\"Editer\">&#xE254;</i>"; ?>
                        </td>

                    </tr>
                <?php } ?>

                </tbody>
            </table>

            <div class="clearfix">
                <div class="hint-text">affichage <b><?php echo $limit ?></b> de <b><?php echo $rowwww['count'] ?></b>
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
    <form action="logout.php" method="POST">
        <button type="submit" name="logout" class="btn btn-primary">Logout</button>
    </form>
</div>
<div id="addenseignant" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un enseignant</h4>
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

<script>
    // Fonction pour afficher les champs de saisie et le bouton
    function displayInputFields(studentId, matiereId) {
        // Création des éléments DOM
        const popup = document.createElement('div');
        popup.className = 'popup';
        const popupContent = document.createElement('div');
        popupContent.className = 'popup-content';
        const heading = document.createElement('h2');
        heading.textContent = 'Saisissez les valeurs';
        const input1 = document.createElement('input');
        input1.type = 'text';
        input1.placeholder = 'Note Exam';
        const input2 = document.createElement('input');
        input2.type = 'text';
        input2.placeholder = 'Note Ds';
        const button = document.createElement('button');
        button.textContent = 'Enregistrer';
        const closeButton = document.createElement('button');
        closeButton.textContent = 'Fermer';
        const buttonWrapper = document.createElement('div');
        buttonWrapper.className = 'button-wrapper';

        // Ajout des éléments au popup
        popupContent.appendChild(heading);
        popupContent.appendChild(input1);
        popupContent.appendChild(input2);
        popupContent.appendChild(button);
        buttonWrapper.appendChild(closeButton);
        buttonWrapper.appendChild(button);
        popupContent.appendChild(buttonWrapper);
        popup.appendChild(popupContent);
        document.body.appendChild(popup);

        // ...

        // Gestionnaire d'événement pour le bouton
        button.addEventListener('click', () => {
            const value1 = input1.value;
            const value2 = input2.value;

            // Envoi des données via AJAX
            const xhr = new XMLHttpRequest();
            const url = 'update.php';
            const params = `studentId=${studentId}&matiereId=${matiereId}&value1=${value1}&value2=${value2}`;
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Traitement de la réponse
                    console.log(xhr.responseText);

                    // Rafraîchir la page
                    location.reload();
                }
            };
            xhr.send(params);

            // Fermeture du popup
            document.body.removeChild(popup);
        });

        closeButton.addEventListener('click', () => {
            // Fermeture du popup
            document.body.removeChild(popup);
        });
    }

    // Récupération des lignes du tableau
    const students = document.querySelectorAll('.student');

    // Ajout des gestionnaires d'événements aux lignes du tableau
    students.forEach((student) => {
        student.addEventListener('click', () => {
            const studentId = student.dataset.userId;
            const matiereId = student.dataset.matiereId;
            displayInputFields(studentId, matiereId);
        });
    });
</script>

</body>
</html>