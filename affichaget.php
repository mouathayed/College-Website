<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<style>
    body {
        background-image: url('back1.jpg');
        background-size: cover;
        background-position: center center;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    table {
        background-color: rgba(255, 255, 255, 0.8);
    }

    table th,
    table td {
        color: #000;
    }
    .popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .popup-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        max-width: 500px;
        text-align: center;
    }

    .popup-content h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .popup-content input[type="text"] {
        padding: 10px;
        font-size: 16px;
        width: 100%;
        margin-bottom: 20px;
    }

    .popup-content button {
        background-color: #102e52;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }



</style>
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
echo "<table class=\"table table-striped table-bordered table-hover\"><thead class=\"thead-dark\"><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>id matiere</th><th>Examen</th><th>Controle continu</th></tr></thead><tbody>";
foreach ($result2 as $row) {
    // Affichage du tableau



    echo "<tr class=\"student\"><td>" . $row["Id_user"] . "</td><td>" . $row["nom"] . "</td><td>" . $row["Prénom"]. "</td><td>" . $row["Id_matiere"] . "</td><td>"  . $row["note_exam"] . "</td><td>" . $row["note_ds"] . "</td></tr>";


}
echo "</tbody></table></div>";


// Fermeture de la connexion à la base de données

?>
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
<!-- Ajouter ce code à la fin de la page, juste avant la balise de fermeture du corps de la page -->
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
        input1.placeholder = 'Valeur 1';
        const input2 = document.createElement('input');
        input2.type = 'text';
        input2.placeholder = 'Valeur 2';
        const button = document.createElement('button');
        button.textContent = 'Enregistrer';

        // Ajout des éléments au popup
        popupContent.appendChild(heading);
        popupContent.appendChild(input1);
        popupContent.appendChild(input2);
        popupContent.appendChild(button);
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

// ...

    }

    // Récupération des lignes du tableau
    const students = document.querySelectorAll('.student');

    // Ajout des gestionnaires d'événements aux lignes du tableau
    students.forEach((student) => {
        student.addEventListener('click', () => {
            const studentId = student.querySelector('td:first-child').textContent;
            const matiereId = student.querySelector('td:nth-child(4)').textContent;
            displayInputFields(studentId, matiereId);
        });
    });

</script>

</body>