<?php
session_start();
    date_default_timezone_set("Africa/tunis");
    include "config.php";
if(isset($_POST['login'])){
    $_SESSION['username'] = $_POST['username'];
    $email = $_POST['username'];
    $password = $_POST['mdp'];
    $sql_login = "SELECT * FROM utilisateur WHERE Email=:email AND Mdp=:password";
    $stmt_login = $pdo->prepare($sql_login);
    $stmt_login->bindParam(':email', $email);
    $stmt_login->bindParam(':password', $password);
    $stmt_login->execute();

    if($stmt_login->rowCount() == 1){
        $data = $stmt_login->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $data['Id_user'];
        $_SESSION['timeout'] = time()+1800;
        $_SESSION['login_at'] = date('h:m:s a');
        sleep(1);
        if($data['User_role']=='admin'){
        header('location:admin/etudiantadmin.php');
        }elseif($data['User_role']=='enseignant'){
            header('location:enseignant.php');
        }elseif($data['User_role']=='etudiant'){
            header('location:etudiant.php');
        }
    }
else {
    $_SESSION['error'] = 'Le nom d utilisateur ou le mot de passe peut être erroné';
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Login</title>
    <style>
        #login
        {
            margin: 18% 30%;
            border: 1px solid lightgray;
            padding: 10px 20px 40px;
            box-shadow: 2px 5px 5px 2px lightgray;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="container" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: center; " >
            <img src="images/Logo.png" alt="A beautiful picture" style="width: 200px; height: auto; margin: 0 auto;">
        </div>
    </div>
</div>

<div class="container">
  <div id="login">
    <div class="mb-4"><h1 class="text-center">Login</h1></div>
    <?php if(isset($_SESSION['error'])){ ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>
    <form action="login.php" method="POST">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class='fas fa-user'></i></span>
            </div>
            <label for="username"></label><input type="text" class="form-control" placeholder="Enter Username" name="username" >
            <script>
                var inputUsername = document.getElementById('username');
                inputUsername.addEventListener('change', function() {
                    localStorage.setItem('username', inputUsername.value);
                });
            </script>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class='fas fa-key'></i></span>
            </div>
            </label><input type="password" class="form-control" placeholder="Enter Password"  name="mdp"  >
            <div class="input-group-append">
                <button type="button" class="input-group-text" onclick="passwordToggle()" id="toggle-btn"><i class='far fa-eye-slash'></i></button>
            </div>
        </div>
        <button type="submit" class="btn btn-danger btn-block" name="login">Login</button>
    </form>
  </div>
</div>
</body>
</html>
<script type="text/javascript">
    //Password visibility
    function passwordToggle(){
        const btn = document.getElementById('toggle-btn');
        const pw = document.getElementById('password');
        if(pw.type === 'password'){
            pw.type = 'text'
            btn.innerHTML = "<i class='far fa-eye'></i>"
        }else{
            pw.type = 'password'
            btn.innerHTML = "<i class='far fa-eye-slash'></i>"
        }
    }
    //Error message hide
    setTimeout(function(){
        document.getElementsByClassName('alert')[0].style.display = 'none';
    }, 3000);
</script>

