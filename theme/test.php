<?php 
include 'sessionController.php';
require_once('connection.php');

// Verificar si hay un término de búsqueda
$searchTerm = isset($_GET['searchTerm']) ? '%' . $_GET['searchTerm'] . '%' : null;

try {
  if ($searchTerm) {
    // Si hay un término de búsqueda, se realiza la búsqueda
    $postsStmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE :searchTerm ORDER BY pub_date ASC");
    $postsStmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
  } else {
    // Si no hay término de búsqueda, se muestran todos los posts
    $postsStmt = $pdo->prepare("SELECT * FROM posts ORDER BY pub_date ASC");
  }
  $postsStmt->execute();
  $posts = $postsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}



function getFirstImageForPost($pdo, $postId) {
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


// código para comprobar si el usuario es administrador
require_once('adminController.php');

$userId = getUserID();

?>

<!DOCTYPE html>

<html lang="en">
<head>

  <meta charset="utf-8">
  <title>TFC CAMBIAR</title>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-+gRMLD25WHEnXDtO0+eY4c+gxpCXSv8+HbYNCTmRX3RmeNns5B8CJy4kqjxk6OJN" crossorigin="anonymous">

  <style>
    #formulario {
      display: <?php echo $window ? 'none' : 'flex'; ?>;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 20px;
      border-top: 1px solid #ccc;
      background-color: #fff;
      box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
      align-items: center;
      z-index: 1000;
    }
    #cerrar-btn {
      background: none;
      border: none;
      font-size: 16px;
      cursor: pointer;
      margin-left: auto;
    }
    #aceptar-btn {
      margin-left: 20px;
    }
    .mensaje {
      flex-grow: 1;
    }
  </style>
</head>
<body>
<header class="navigation fixed-top">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand font-tertiary h3" href="index.php"><img src="images/logo.png" alt="CityTasks" style="height: 90px;"></a>
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
        if($isAdmin){
          echo "<li class='nav-item'>
          <a class='nav-link' href='admin-panel.php'>Panel de Administración</a>
          </li>" ;
        }

        if ($logged) {
          echo "<li class='nav-item'>
          <a class='nav-link' href='logout.php'>Cerrar Sesión</a>
          </li>" ;

          echo "<li class='nav-item'>
          <a class='nav-link' href='account.php?id=" . $userId ."'>Mi Cuenta</a>
          </li>" ;
        }else {
          echo "<li class='nav-item'>
          <a class='nav-link' href='login.php'>Iniciar Sesión</a>
          </li>" ;
        }
        ?>
        <li class="nav-item">
          <a class="btn btn-sm btn-success" href="<?php if($logged){echo "create.php";}else{echo "login.php";} ?>">Publica un Servicio</a>
        </li>

      </ul>
    </div>
  </nav>
</header>

<!-- hero area -->
<section class="hero-area bg-primary">
  <div class="container">
    <div class="row">
      <div class="col-lg-11 mx-auto">
        <h1 class="text-white font-tertiary">INDEX</h1>
      </div>
    </div>
  </div>
  
  <div class="layer-bg w-100">
    <img class="img-fluid w-100" src="images/illustrations/leaf-bg.png" alt="bg-shape">
  </div>
  
 
</section>
<!-- /hero area -->

<!-- Formulario de búsqueda -->
<section class="section">
  <div class="container">
    <div class="row mb-3">
      <div class="col-12">
      <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row g-0 align-items-center">
      <div class="col-12">
        <div class="input-group">
          <!-- <input class="form-control" type="search" name="searchTerm" placeholder="Introduzca palabra clave..." aria-label="Buscar">
          <div class="input-group-append">
            <button class="btn btn-success" type="submit">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
              </svg>
            </button> -->

            <div class="input-group">
            <input type="search" class="form-control mr-2" name="searchTerm" placeholder="Introduzca palabra clave..." aria-label="Search" aria-describedby="search-addon" />
            <button type="submit" class="btn btn-sm btn-success mb-1" data-mdb-ripple-init>Buscar</button>
          </div>
          </div>
        </div>
      </div>
    </form>

    


        <?php if(empty($posts)){
          echo "<p>No se encontraron publicaciones. </p>";
        } ?>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row mb-5">
      <div class="col-12">
        <div class="btn-group btn-group-toggle justify-content-center d-flex flex-wrap" data-toggle="buttons">
          <label class="btn btn-sm btn-primary active">
            <input type="radio" name="shuffle-filter" value="all" checked="checked" /> Todas
          </label>
          <?php
                require_once('categories.php');
                
                foreach($categories as $category){
                    echo "<label class='btn btn-sm btn-primary'>
                    <input type='radio' name='shuffle-filter' value='$category' />$category
                    </label>";
                }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- blog -->
<section class="section">
  <div class="container">
    <div class="row shuffle-wrapper">      
      <?php 
      foreach($posts as $post) :
        $preview = (strlen($post['description']) > 100) ? substr($post['description'], 0, 100) . '...' : $post['description'];
    ?>
      <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0 shuffle-item" data-groups="[&quot;<?php echo $post['category'] ?>&quot;]">
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
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
              </svg>
              <p class="m-2">Aun por definir</p>
            </div>
            <a href="post.php?id=<?php echo urldecode($post['id']);?>" class="btn btn-xs btn-primary">Ver Más</a>
          </div>
        </article>
      </div>
      <?php endforeach; ?>  
    </div>
  </div>
</section>
<!-- /blog -->

<?php 
require_once('cookieBanner.php');
?>

<!-- footer -->
<footer class="bg-dark pt-6">
 <div class="section bg-dark text-light py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h4 class="text-light">CityTasks</h4>
          <ul class="list-unstyled">
            <li><a href="footer-pages/whoweare.php" class="text-white-50 small" title="¿Quiénes somos?">¿Quiénes somos?</a></li>
            <li><a href="footer-pages/instructions.php" class="text-white-50 small" title="Cómo funciona">Cómo funciona</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h4 class="text-light">Soporte</h4>
          <ul class="list-unstyled">
            <li><a href="footer-pages/support.php" class="text-white-50 small" title="Centro de ayuda">Centro de ayuda</a></li>
            <li><a href="footer-pages/user-rules.php" class="text-white-50 small" title="Normas de uso">Normas de uso</a></li>
            <li><a href="footer-pages/tips.php" class="text-white-50 small" title="Consejos">Consejos</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h4 class="text-light">Legal</h4>
          <ul class="list-unstyled">
            <li><a href="footer-pages/legal-terms.php" class="text-white-50 small" title="Aviso legal">Aviso legal</a></li>
            <li><a href="footer-pages/use-conditions.php" class="text-white-50 small" title="Condiciones de uso">Condiciones de uso</a></li>
            <li><a href="footer-pages/privacy-policy.php" class="text-white-50 small" title="Política de privacidad">Política de privacidad</a></li>
            <li><a href="footer-pages/cookies-policy.php" class="text-white-50 small" title="Política de Cookies">Política de Cookies</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="border-top text-center border-dark py-5">
    <p class="mb-0 text-light">Copyright &copy;<script>
        var CurrentYear = new Date().getFullYear()
        document.write(CurrentYear)
      </script> Diseñado &amp; Desarrollado <a class="text-white-50" href="Themefisher">Sergio Pulido Salvador</a></p>
  </div>
</footer>
<!-- /footer -->

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
