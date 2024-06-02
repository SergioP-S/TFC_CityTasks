<?php
include 'sessionController.php';
require_once ('connection.php');

if (isset($_GET['id'])) {
  $accountId = intval($_GET['id']);

  //Consulta para la información del usuario 
  $userStmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
  $userStmt->bindParam(':id', $accountId); //Se selecciona el usuario propietario del post
  $userStmt->execute();
  $user = $userStmt->fetch(PDO::FETCH_ASSOC);

  //Consulta para los posts propiedad del usuario
  $postStmt = $pdo->prepare("SELECT * FROM posts WHERE author = :author_id");
  $postStmt->bindParam(':author_id', $user['username']); //Se seleccionan los posts del usuario
  $postStmt->execute();
  $posts = $postStmt->fetchAll(PDO::FETCH_ASSOC);

} else {
  echo "<script>alert('Esta oferta no existe');</script>";
  //header('Location: index.php');
}

function getFirstImageForPost($pdo, $postId)
{
  try {
    // Consulta SQL para obtener la primera imagen asociada al post_id
    $sql = "SELECT * FROM images WHERE post = :postid LIMIT 1";
    $imageStmt = $pdo->prepare($sql);
    $imageStmt->bindParam(':postid', $postId, PDO::PARAM_INT);
    // Ejecutar la consulta
    $imageStmt->execute();
    // Obtener el resultado
    $image = $imageStmt->fetch(PDO::FETCH_ASSOC);
    if ($image) {
      // Procesar la imagen obtenida (ej. mostrarla)
      echo '<img src="data:image/jpeg;base64,' . base64_encode($image['image']) . '" />';
      return $image;
    } else {
      //Si el post no tuviera imagen se muestra una imagen por defecto
      echo '<img class="" src="../source/images/imageNotFound.png" />';
      return null;
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return null;
  }
}

if (getUserID() == $accountId) {
  $myAccount = true;
} else {
  $myAccount = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $passwd = $_POST['passwd'];
  $confirm_passwd = $_POST['confirm_passwd'];
  $profile_picture = $_FILES['profile_picture'];

  $update_query = "UPDATE users SET ";
  $params = [];

  if (!empty($passwd) && $passwd === $confirm_passwd) {
    // Encriptar la contraseña
    $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);
    $update_query .= "password = :password, ";
    $params[':password'] = $hashed_password;
  }

  if ($profile_picture['size'] > 0) {
    $image_data = file_get_contents($profile_picture['tmp_name']);
    $image_info = getimagesize($profile_picture['tmp_name']);

    if ($image_info[0] < 400 || $image_info[1] < 400) {
      echo "La imagen debe ser de al menos 400x400 píxeles.";
      exit;
    }

    // Redimensionar la imagen si es necesario
    if ($image_info[0] > 400 || $image_info[1] > 400) {
      $image = imagecreatefromstring($image_data);
      $new_image = imagescale($image, 400, 400);
      ob_start();
      imagejpeg($new_image);
      $image_data = ob_get_clean();
      imagedestroy($image);
      imagedestroy($new_image);
    }

    $update_query .= "image = :image, ";
    $params[':image'] = $image_data;
  }

  // Remover la última coma y espacio
  $update_query = rtrim($update_query, ', ');
  $update_query .= " WHERE id = :id";
  $params[':id'] = $accountId;

  // Ejecutar la consulta de actualización
  $update_stmt = $pdo->prepare($update_query);
  if ($update_stmt->execute($params)) {
    echo "Perfil actualizado exitosamente.";
  } else {
    echo "Error al actualizar el perfil.";
  }
}

require_once ('adminController.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php if ($myAccount) {
    echo "Mi Perfil";
  } else {
    echo "Perfil de " . strtoupper($user['username']);
  } ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Creative Portfolio Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Kross Template v1.0">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
  <header class="navigation fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand font-tertiary h3" href="index.php"><img src="images/logo.png" alt="CityTasks"
          style="height: 90px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-center" id="navigation">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <?php
          if ($isAdmin) {
            echo "<li class='nav-item'>
          <a class='nav-link' href='admin-panel.php'>Panel de Administración</a>
          </li>";
          }

          if ($logged) {
            echo "<li class='nav-item'>
          <a class='nav-link' href='logout.php'>Cerrar Sesión</a>
          </li>";

            echo "<li class='nav-item'>
          <a class='nav-link' href='account.php?id=" . getUserID() . "'>Mi Cuenta</a>
          </li>";
          } else {
            echo "<li class='nav-item'>
          <a class='nav-link' href='login.php'>Iniciar Sesión</a>
          </li>";
          }
          ?>
          <li class="nav-item">
            <a class="btn btn-sm btn-success" href="<?php if ($logged) {
              echo "create.php";
            } else {
              echo "login.php";
            } ?>">Publica un Servicio</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <section class="page-title bg-primary position-relative">
    <div class="container">
    </div>
    <img src="images/illustrations/page-title.png" alt="illustrations" class="bg-shape-1 w-100">
    <img src="images/illustrations/leaf-pink-round.png" alt="illustrations" class="bg-shape-2">
    <img src="images/illustrations/leaf-orange.png" alt="illustrations" class="bg-shape-4">
    <img src="images/illustrations/leaf-yellow.png" alt="illustrations" class="bg-shape-5">
    <img src="images/illustrations/dots-group-cyan.png" alt="illustrations" class="bg-shape-6">
    <img src="images/illustrations/leaf-cyan-lg.png" alt="illustrations" class="bg-shape-7">
  </section>
  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <?php if (!empty($user['image'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($user['image']); ?>" alt="profile-picture"
              class="img-fluid rounded-circle border border-primary">
          <?php else: ?>
            <img src="images/400.png" alt="profile-picture" class="img-fluid rounded-circle border border-primary">
          <?php endif; ?>
        </div>
        <div class="col-lg-8 col-md-6">
          <h2 class="mb-3">
            <?php
            if ($myAccount) {
              echo 'Mi cuenta';
            } else {
              echo 'La cuenta de ' . htmlspecialchars($user['username']);
            }
            ?>
          </h2>
          <ul class="list-unstyled">
            <li class="mb-2"> <b>Nombre:</b> <?php echo $user['name']; ?></li>
            <li class="mb-2"> <b>Email:</b> <?php echo $user['email']; ?></li>
          </ul>
          <?php if ($myAccount): ?>
            <div class="container mt-5">
              <div class="row">
                <div class="col-auto">
                  <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editProfileModal">Editar
                    Perfil</button>
                </div>
                <div class="col-auto">
                  <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteProfileModal">Eliminar
                    Perfil</button>
                </div>
              </div>
            </div>
          <?php endif; ?>


          <div class="modal fade" id="deleteProfileModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteProfileModalLabel">Eliminar Perfil</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="deleteProfileForm" action="deleteAccount.php" method="POST">
                    <input type="int" name="accountId" id="" hidden value="<?php echo $accountId ?>">
                    <div class="form-group">
                      <label for="confirm">Escriba "CONFIRMAR" para eliminar su perfil:</label>
                      <input type="text" class="form-control" id="confirm" name="confirm" required>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Modificar Datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="account.php?id=<?php echo $accountId; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="passwd">Contraseña:</label>
                        <input type="password" id="passwd" name="passwd" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="confirm_passwd">Confirmar Contraseña:</label>
                        <input type="password" id="confirm_passwd" name="confirm_passwd" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Foto de Perfil:</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function validateForm() {
    var passwd = document.getElementById('passwd').value;
    var confirmPasswd = document.getElementById('confirm_passwd').value;
    var profilePicture = document.getElementById('profile_picture').value;

    if ((passwd === '' || confirmPasswd === '') && profilePicture === '') {
        alert('Por favor, rellena los campos de contraseña o selecciona una imagen para continuar.');
        return false;
    }

    if (passwd !== confirmPasswd) {
        alert('Las contraseñas no coinciden.');
        return false;
    }

    return true;
}
</script>

        </div>
      </div>
    </div>
  </section>
  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h3 class="section-title">
            <?php if ($myAccount) {
              echo "Mis publicaciones";
            } else {
              echo "Publicaciones de " . strtoupper($user['username']);
            } ?>
          </h3>
        </div>
        <div class="row">
          <?php

          if (empty($posts)) {
            echo '<p class="text-center">Aún no se ha publicado nada</p>';
          }
          foreach ($posts as $post):
            $preview = (strlen($post['description']) > 100) ? substr($post['description'], 0, 100) . '...' : $post['description'];
            ?>
            <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0 ">
              <article class="card shadow" style="height: 100%;">
                <div class="image-container" style="height: 200px; overflow: hidden;">
                  <?php getFirstImageForPost($pdo, $post['id']); ?>
                </div>
                <div class="card-body">
                  <div class="text-container" style="height: 150px; overflow: hidden;">
                    <h4 class="card-title"><a class="text-dark" href="#"><?php echo $post['title']; ?></a></h4>
                    <p class="card-text"><?php echo $preview; ?></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                      <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                    </svg>
                    <p class="m-2">Aun por definir</p>
                  </div>
                  <a href="post.php?id=<?php echo urldecode($post['id']); ?>" class="btn btn-xs btn-primary">Ver Más</a>
                  <?php if ($myAccount) {
                    echo '<a href="edit.php?id=' . urlencode($post['id']) . '" class="btn btn-xs btn-success">Modificar</a>';
                    echo '<a href="delete.php?id=' . urlencode($post['id']) . '" class="btn btn-xs btn-danger" onclick="return confirm(\'¿Estás seguro que deseas borrarlo?\');">Eliminar</a>';
                  }
                  ?>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
  <footer class="bg-dark pt-6">
    <div class="section bg-dark text-light py-4">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <h4 class="text-light">CityTasks</h4>
            <ul class="list-unstyled">
              <li><a href="footer-pages/whoweare.php" class="text-white-50 small" title="¿Quiénes somos?">¿Quiénes
                  somos?</a></li>
              <li><a href="footer-pages/instructions.php" class="text-white-50 small" title="Cómo funciona">Cómo
                  funciona</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h4 class="text-light">Soporte</h4>
            <ul class="list-unstyled">
              <li><a href="footer-pages/support.php" class="text-white-50 small" title="Centro de ayuda">Centro de
                  ayuda</a></li>
              <li><a href="footer-pages/user-rules.php" class="text-white-50 small" title="Normas de uso">Normas de
                  uso</a></li>
              <li><a href="footer-pages/tips.php" class="text-white-50 small" title="Consejos">Consejos</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h4 class="text-light">Legal</h4>
            <ul class="list-unstyled">
              <li><a href="footer-pages/legal-terms.php" class="text-white-50 small" title="Aviso legal">Aviso legal</a>
              </li>
              <li><a href="footer-pages/use-conditions.php" class="text-white-50 small"
                  title="Condiciones de uso">Condiciones de uso</a></li>
              <li><a href="footer-pages/privacy-policy.php" class="text-white-50 small"
                  title="Política de privacidad">Política de privacidad</a></li>
              <li><a href="footer-pages/cookies-policy.php" class="text-white-50 small"
                  title="Política de Cookies">Política de Cookies</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="border-top text-center border-dark py-5">
      <p class="mb-0 text-light">Copyright &copy;
        <script>
          var CurrentYear = new Date().getFullYear()
          document.write(CurrentYear)
        </script> Diseñado &amp; Desarrollado <a class="text-white-50" href="Themefisher">Sergio Pulido Salvador</a>
      </p>
    </div>
  </footer>
  <script src="plugins/jQuery/jquery.min.js"></script>
  <script src="plugins/bootstrap/bootstrap.min.js"></script>
  <script src="plugins/slick/slick.min.js"></script>
  <script src="plugins/shuffle/shuffle.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>