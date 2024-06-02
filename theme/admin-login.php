<?php
include 'sessionController.php';
require_once('connection.php'); // Asumiendo que connection.php configura $pdo

// Verificar el inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    try {
        // Preparar y ejecutar la consulta SQL
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Verificar si el usuario existe
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user['role'] != "ADMIN"){
                echo "<script> alert('El usuario no es administrador.');</script>";
            } else if(!password_verify($passwd, $user['password'])){
                echo "<script> alert('Contraseña Incorrecta.');</script>";
            } else {
                require_once('logout.php');

                // Iniciar una nueva sesión con el rol de ADMIN
                startSession();
                setUserSession($user['email']);

                // Redirigir al panel de administración
                header("Location: admin-panel.php");
                exit();
            }
        } else {
            $error = "El correo no está registrado.";
        }
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Log In</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Creative Portfolio Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Kross Template v1.0">
  <meta name="theme-name" content="kross" />
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
<section class="section section-on-footer" data-background="images/backgrounds/bg-dots.png">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="section-title">Panel de Administración</h2>
      </div>
      <div class="col-lg-8 mx-auto">
        <div class="bg-white rounded text-center p-5 shadow-down">
          <h4 class="mb-80">Panel de administración, solo para administradores.</h4>
          <?php if (isset($error)) { ?>
              <div class="alert alert-danger" role="alert">
                  <?php echo $error; ?>
              </div>
          <?php } ?>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row">
            <div class="col-md-12">
              <input type="email" id="email" name="email" placeholder="Dirección de Correo Electrónico" class="form-control px-0 mb-4" required>
            </div>
            <div class="col-md-12">
              <input type="password" id="passwd" name="passwd" placeholder="Contraseña" class="form-control px-0 mb-4" required>
            </div>
            <div class="col-lg-6 col-10 mx-auto">
              <button class="btn btn-primary w-100">Iniciar Sesión</button>
            </div>
          </form>
          <hr>
          <p>Inicio de sesión de usuarios corrientes <a href="login.php">aquí</a>.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="plugins/jQuery/jquery.min.js"></script>
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="plugins/slick/slick.min.js"></script>
<script src="plugins/shuffle/shuffle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
