<?php
include 'sessionController.php';
require_once('connection.php');

// Si la sesión no está establecida se redirige al index
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
} else {
    try {
        $checkAdminStmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $checkAdminStmt->bindParam(':email', $_SESSION['email']);
        $checkAdminStmt->execute();
        $checkAdmin = $checkAdminStmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    // Si el usuario con la sesión iniciada no es ADMIN se le devuelve al index
    if ($checkAdmin['role'] != "ADMIN") {
        header("Location: index.php");
        exit();
    }
}

// Verificar el inicio de sesión para posts
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id'])) {
        $postId = intval($_POST['post_id']);
        // Consulta para la información del post
        $postStmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
        $postStmt->bindParam(':id', $postId);
        $postStmt->execute();
        $post = $postStmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Manejar la eliminación del post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_post_id'])) {
    $deletePostId = intval($_POST['delete_post_id']);
    try {
        $deleteStmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
        $deleteStmt->bindParam(':id', $deletePostId);
        $deleteStmt->execute();
        echo "<p>El post con ID $deletePostId ha sido eliminado.</p>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Verificar el inicio de sesión para usuarios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);
    // Consulta para la información del usuario
    $userStmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $userStmt->bindParam(':id', $userId);
    $userStmt->execute();
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);
}

// Manejar la eliminación del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    $deleteUserId = intval($_POST['delete_user_id']);
    try {
        $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $deleteStmt->bindParam(':id', $deleteUserId);
        $deleteStmt->execute();
        echo "<p>El usuario con ID $deleteUserId ha sido eliminado.</p>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>Panel de Administración</title>

  <!-- Mobile Specific Metas -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">

  <!-- Main Stylesheet -->
  <link href="css/style.css" rel="stylesheet">
  
  <!-- Enlace FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-+gRMLD25WHEnXDtO0+eY4c+gxpCXSv8+HbYNCTmRX3RmeNns5B8CJy4kqjxk6OJN" crossorigin="anonymous">

</head>
<body>
<!-- login -->
<section class="section section-on-footer" data-background="images/backgrounds/bg-dots.png">
  <div class="container" style="max-width: 1200px;">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="section-title">Panel de Administración</h2>
      </div>
      <div class="col-lg-6">
        <div class="bg-white rounded text-center p-5 shadow-down">
          <h4 class="mb-80">Administración de Publicaciones</h4>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row">
            <div class="col-md-12">
              <input type="number" id="post_id" name="post_id" placeholder="Ingrese el ID del post" class="form-control px-0 mb-4" min="0" required>
            </div>
            <div class="col-lg-6 col-10 mx-auto">
              <button class="btn btn-primary w-100">Ver Post</button>
            </div>
          </form>
          <?php 
            if (isset($post)) {
                if (empty($post)) {
                    echo "<p>El id solicitado no existe</p>";
                } else {
                    echo "<p class='text-left'><span class='font-weight-bold'>ID de la Publicación:</span> " . htmlspecialchars($post['id']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Título:</span> " . htmlspecialchars($post['title']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Descripción:</span> " . htmlspecialchars($post['description']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Autor:</span> " . htmlspecialchars($post['author']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Categoría:</span> " . htmlspecialchars($post['category']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Latitud:</span> " . htmlspecialchars($post['latitude']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Longitud:</span> " . htmlspecialchars($post['longitude']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Fecha de Publicación:</span> " . htmlspecialchars($post['pub_date']) . "</p>";
                    if (isset($post['upd_date'])) {
                        echo "<p class='text-left'><span class='font-weight-bold'>Última fecha de Actualización:</span> " . htmlspecialchars($post['upd_date']) . "</p>";
                    } else {
                        echo "<p class='text-left'><span class='font-weight-bold'>Última fecha de Actualización:</span> No se ha actualizado</p>";
                    }
                    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' onsubmit='return confirmDelete();'>
                            <input type='hidden' name='delete_post_id' value='" . htmlspecialchars($post['id']) . "'>
                            <button type='submit' class='btn btn-danger'>Eliminar Post</button>
                          </form>";
                }
            }
          ?>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="bg-white rounded text-center p-5 shadow-down">
          <h4 class="mb-80">Administración de Usuarios</h4>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row">
            <div class="col-md-12">
              <input type="number" id="user_id" name="user_id" placeholder="Ingrese el ID del usuario" class="form-control px-0 mb-4" min="0" required>
            </div>
            <div class="col-lg-6 col-10 mx-auto">
              <button class="btn btn-primary w-100">Ver Usuario</button>
            </div>
          </form>
          <?php 
            if (isset($user)) {
                if (empty($user)) {
                    echo "<p>El id solicitado no existe</p>";
                } else {
                    echo "<p class='text-left'><span class='font-weight-bold'>ID del Usuario:</span> " . htmlspecialchars($user['id']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Nombre de Usuario:</span> " . htmlspecialchars($user['username']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Nombre:</span> " . htmlspecialchars($user['name']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Apellidos:</span> " . htmlspecialchars($user['surname']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Email:</span> " . htmlspecialchars($user['email']) . "</p>";
                    echo "<p class='text-left'><span class='font-weight-bold'>Rol:</span> " . htmlspecialchars($user['role']) . "</p>";
                    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' onsubmit='return confirmDeleteUser();'>
                            <input type='hidden' name='delete_user_id' value='" . htmlspecialchars($user['id']) . "'>
                            <button type='submit' class='btn btn-danger'>Eliminar Usuario</button>
                          </form>";
                }
            }
          ?>
        </div>
      </div>
      <a href="index.php">Volver al Inicio</a>
    </div>
  </div>
</section>
<!-- /login -->

<!-- jQuery -->
<script src="plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>

<script>
function confirmDelete() {
    return confirm('¿Estás seguro de que deseas eliminar este post?');
}
function confirmDeleteUser() {
    return confirm('¿Estás seguro de que deseas eliminar este usuario?');
}
</script>

</body>
</html>
