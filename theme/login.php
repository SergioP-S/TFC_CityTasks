<?php
include 'sessionController.php';

require_once('connection.php');
// Verificar el inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST["email"];
    $passwd = $_POST["passwd"];

    // Consulta preparada para verificar la existencia del usuario (case sensitive)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar si el usuario existe y la contraseña es correcta
    if ($userInfo && password_verify($passwd, $userInfo['password'])) {
        // Inicio de sesión exitoso
        session_start(); // Inicia la sesión si aún no está iniciada
       // $_SESSION['email'] = $userInfo['email']; // Establece la variable de sesión
        setUserSession($userInfo['email']);

        // //MODIFICAR
        // if ($userInfo['role'] == "ADMIN"){
        //     header("Location: menu.php"); //Cambiar 
        // } else if($userInfo['role'] == "USER"){
        //     header("Location: index.php");
        // }
        header("Location: index.php");
      
        exit();
    } else {
        // Inicio de sesión fallido
        //echo "<p class='error'>Error: Usuario o contraseña incorrectos.</p>";
        echo "<script>alert('Error: Usuario o Contraseña incorrectos.');</script>";
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
  <title>Log In</title>

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
<!-- login -->
<section class="section section-on-footer" data-background="images/backgrounds/bg-dots.png">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="section-title">CityTasks - Inicio de Sesión</h2>
      </div>
      <div class="col-lg-8 mx-auto">
        <div class="bg-white rounded text-center p-5 shadow-down">
          <h4 class="mb-80">Introduzca sus datos para iniciar sesión</h4>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row">
            <div class="col-md-12">
              <input type="email" id="email" name="email" placeholder="Correo Electrónico" class="form-control px-0 mb-4" required>
            </div>
            <div class="col-md-12">
              <input type="password" id="passwd" name="passwd" placeholder="Contraseña" class="form-control px-0 mb-4" required>
            </div>
            <div class="col-lg-6 col-10 mx-auto">
              <button class="btn btn-primary w-100">Acceder</button>
            </div>
          </form>
          <hr>
          <p>¿Todavía no tienes cuenta? Registrate <a href="sign-up.php">aquí</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /login -->

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

</body>
</html>
