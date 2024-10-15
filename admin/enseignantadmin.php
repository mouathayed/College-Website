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
$sql2 = "SELECT u.Nom, u.Prénom, u.Email, u.Mdp,m.nom_matiere FROM utilisateur as u ,matiere as m where User_role='enseignant' and u.Id_user=m.id_user LIMIT :limit OFFSET :offset";
$result2 = $pdo->prepare($sql2);
$limit = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$result2->bindParam(':limit', $limit, PDO::PARAM_INT);
$result2->bindParam(':offset', $offset, PDO::PARAM_INT);
$result2->execute();
$sql_count = "SELECT COUNT(*) AS count FROM utilisateur where User_role ='enseignant'";
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
                        <a href="etudiantadmin.php" class="btn btn-danger btn-rounded""><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span> Etudiants</span></a>
                        <a href="matieres.php" class="btn btn-danger btn-rounded"><i class="fa fa-book" aria-hidden="true"></i><span>Matieres</span></a>
                    </div>
                </div>
                <div style="height: 20px;"></div><div style="height: 20px;"></div>
                <div class="row">

                    <div class="col-sm-6">
                        <h2>Liste <b>des enseignants</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addenseignant" class="btn btn-info add-new" data-toggle="modal">
                            <i class="material-icons">&#xE147;</i> <span>Ajouter un enseignant</span>
                        </a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>

                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Matiere</th>
                    <th>email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result2->fetch(PDO::FETCH_ASSOC)) { ?>

                    <tr class="student" data-email="<?php echo $row["Email"]; ?>">
                    <?php echo "<td>" . $row["Nom"] . "</td>";
                    echo "<td>" . $row["Prénom"] . "</td>";
                    echo "<td>" . $row["nom_matiere"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    ?>
                    <td>
                        <i class="material-icons" data-toggle="tooltip" title="Editer">&#xE254;</i>
                        <a href="deleteenseignant.php?email=<?php echo $row["Email"]; ?>" onclick="return confirm('Êtes-vous sûr de bien vouloir supprimer cette enseignant?');" class="delete"><i class="material-icons" data-toggle="tooltip" title="supprimer">&#xE872;</i></a>


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
<div id="addenseignant" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="addenseignant.php" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un enseignant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label>Prenom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="text" class="form-control" id="pass" name="pass" required>
                    </div>
                    <div class="form-group">
                        <label>Matiere</label>
                        <input type="text" class="form-control" id="matiere" name="matiere" required>
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
    function displayInputFields(email) {
        // Création des éléments DOM
        const popup = document.createElement('div');
        popup.className = 'popup';
        const popupContent = document.createElement('div');
        popupContent.className = 'popup-content';
        const heading = document.createElement('h2');
        heading.textContent = 'Saisissez les valeurs';
        const input1 = document.createElement('input');
        input1.type = 'text';
        input1.placeholder = 'Nom';
        const input2 = document.createElement('input');
        input2.type = 'text';
        input2.placeholder = 'Prénom';
        const input3 = document.createElement('input');
        input3.type = 'text';
        input3.placeholder = 'Email';
        const input4 = document.createElement('input');
        input4.type = 'password';
        input4.placeholder = 'Password';
        const buttonWrapper = document.createElement('div');
        buttonWrapper.className = 'button-wrapper';
        const button = document.createElement('button');
        button.textContent = 'Enregistrer';
        const closeButton = document.createElement('button');
        closeButton.textContent = 'Fermer';


        // Ajout des éléments au popup
        popupContent.appendChild(heading);
        popupContent.appendChild(input1);
        popupContent.appendChild(input2);
        popupContent.appendChild(input3);
        popupContent.appendChild(input4);
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
            const value3 = input3.value;
            const value4 = input4.value;

            // Envoi des données via AJAX
            const xhr = new XMLHttpRequest();
            const url = 'editenseignant.php';
            const params = `email=${email}&value1=${value1}&value2=${value2}&value3=${value3}&value4=${value4}`;
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
            const email = student.dataset.email;
            displayInputFields(email);
        });
    });
</script>
</body>
</html>