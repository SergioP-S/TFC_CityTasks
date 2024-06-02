
<?php
// Datos de conexión a la base de datos
require_once('sessionController.php');
if ($logged) {
  header("Location: index.php");
}
// Conexión a la base de datos usando PDO
require_once('connection.php');


// Inserción de nuevos usuarios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtolower(trim($_POST["username"]));
    $name = ($_POST["name"]);
    $surname = ($_POST["surname"]);
    $email = ($_POST["email"]);


    if($_POST["passwd"] != $_POST["passwd-repeat"]){
        echo "<script>alert('Error, ambas contraseñas no coinciden.');</script>";
    } else if(strpos($username, " ") || strpos($email, " ") ){
        echo "<script>alert('El nombre de usuario, contraseña y/o email no pueden contener espacios');</script>";
    }  else{    
        //Se cifra la contraseña
        $passwd = password_hash($_POST["passwd"], PASSWORD_DEFAULT);
        // Consulta preparada para verificar si el usuario ya existe
        $checkUserStmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $checkUserStmt->bindParam(':username', $username);
        $checkUserStmt->execute();
        $existingUser = $checkUserStmt->fetch(PDO::FETCH_ASSOC);

        $checkMailStmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail");
        $checkMailStmt->bindParam(':mail', $email);
        $checkMailStmt->execute();
        $existingMail = $checkMailStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser || $existingMail) {
            //echo "<p class='error'>Error: El nombre de usuario o dirección de correo ya está en uso.</p>";
            echo "<script>alert('El nombre de usuario o correo electrónico ya está en uso');</script>";
        }
        else {
            // Consulta preparada para insertar un nuevo usuario
            $insertUserStmt = $pdo->prepare("INSERT INTO users (username, name, surname, email, password) VALUES (:username, :name, :surname, :mail, :passwd)");
            $insertUserStmt->bindParam(':username', $username);
            $insertUserStmt->bindParam(':name', $name);
            $insertUserStmt->bindParam(':surname', $surname);
            $insertUserStmt->bindParam(':mail', $email);
            $insertUserStmt->bindParam(':passwd', $passwd);

            try {
                $insertUserStmt->execute();
                echo "<script>alert('Usuario registrado con éxito');</script>";
                header("Location: index.php"); // Redirigir a index.php después del registro exitoso
                exit();
            } catch (PDOException $e) {
                echo "<p class='error'>Error al registrar el usuario: " . $e->getMessage() . "</p>";
            }
        }
    }
}
?> 
<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>Sign Up</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Creative Portfolio Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Kross Template v1.0">
  
  <!-- theme meta -->
  <meta name="theme-name" content="kross" />
  
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
  
  <!-- ** Plugins Needed for the Project ** -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">

  <!-- Main Stylesheet -->
  <link href="css/style.css" rel="stylesheet">

</head>
<body>

<!-- contact -->
<section class="section section-on-footer" data-background="images/backgrounds/bg-dots.png">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="section-title">CityTasks - Crear Cuenta</h2>
      </div>
      <div class="col-lg-8 mx-auto">
        <div class="bg-white rounded text-center p-5 shadow-down">
          <h4 class="mb-80">Introduzca sus datos para crear una cuenta</h4>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row">
            <div class="col-md-12">
              <input type="text" id="username" name="username" placeholder="Nombre de usuario" class="form-control px-0 mb-4" maxlength="16" required>
            </div>
            <div class="col-md-12">
              <input type="text" id="name" name="name" placeholder="Nombre" class="form-control px-0 mb-4" maxlength="40" required>
            </div>
            <div class="col-md-12">
              <input type="text" id="surname" name="surname" placeholder="Apellidos" class="form-control px-0 mb-4"  maxlength="60" required>
            </div>
            <div class="col-md-12">
              <input type="email" id="email" name="email" placeholder="Dirección de correo electrónico" class="form-control px-0 mb-4" maxlength="30" required>
            </div>
            <div class="col-md-12">
              <input type="password" id="passwd" name="passwd" placeholder="Contraseña" class="form-control px-0 mb-4" minlength="6" required>
            </div>
            <div class="col-md-12">
              <input type="password" id="passwd-repeat" name="passwd-repeat" placeholder="Repita su Contraseña" minlength="6" class="form-control px-0 mb-4" required>
            </div>
        

            <!--MODIFICAR-->
            <div class=" col-md-12 form-check form-check-inline mb-4">
              <input type="checkbox" id="terms" name="terms" class="form-check-input" required>
              <label for="terms" class="form-check-label">Al registrarse acepta los <a href="footer-pages/cookies-policy.php">Términos y Condiciones</a>.</label>
            </div>

             <!--Captcha de Google-->
            <!-- <div class="col-md-12">
              <div class="g-recaptcha" data-sitekey="6Lfg2d8pAAAAAN9ECiOb0DtV9-LAvtQHlgVkGnH0"></div>
            </div> -->

            <div class="col-lg-6 col-10 mx-auto mt-4">
              <button class="btn btn-primary w-100">Crear Cuenta</button>
            </div>
          </form>
          <hr>
          <p>¿Ya tienes cuenta? Inicia sesión <a href="login.php">aquí</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /contact -->



<!-- jQuery -->
<script src="plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<!-- slick slider -->
<script src="plugins/slick/slick.min.js"></script>
<!-- filter -->
<script src="plugins/shuffle/shuffle.min.js"></script>

<!-- Main Script -->
<script src="js/script.js"></script>

<!--Script Captcha-->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
