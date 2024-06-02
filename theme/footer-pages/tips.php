<?php 
require_once('../adminController.php');
include '../sessionController.php';
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
  <title>¿Quienes Somos?</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Creative Portfolio Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Kross Template v1.0">
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
  
  <!-- ** Plugins Needed for the Project ** -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="../plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="../plugins/themify-icons/themify-icons.css">

  <!-- Main Stylesheet -->
  <link href="../css/style.css" rel="stylesheet">

</head>
<body>
<header class="navigation fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand font-tertiary h3" title="Home" href="../index.php"><img src="../images/logo.png" alt="Home"
          style="height: 90px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse text-center" id="navigation">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="../index.php">Home</a>
          </li>
          <?php
          if ($isAdmin) {
            echo "<li class='nav-item'>
          <a class='nav-link' href='../admin-panel.php'>Panel de Administración</a>
          </li>";
          }

          if ($logged) {
            echo "<li class='nav-item'>
          <a class='nav-link' href='../logout.php'>Cerrar Sesión</a>
          </li>";
          } else {
            echo "<li class='nav-item'>
          <a class='nav-link' href='../login.php'>Iniciar Sesión</a>
          </li>";
          }
          ?>
          <li class="nav-item">
            <a class="btn btn-sm btn-success" href="<?php if ($logged) {
              echo "../create.php";
            } else {
              echo "../login.php";
            } ?>">Publica un Servicio</a>
          </li>

        </ul>
      </div>
    </nav>
  </header>

<!-- page title -->
<section class="page-title bg-primary position-relative">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h1 class="text-white font-tertiary">Blogs</h1>
      </div>
    </div>
  </div>
  <!-- background shapes -->
  <img src="../images/illustrations/page-title.png" alt="illustrations" class="bg-shape-1 w-100">
  <img src="../images/illustrations/leaf-pink-round.png" alt="illustrations" class="bg-shape-2">
  <img src="../images/illustrations/leaf-orange.png" alt="illustrations" class="bg-shape-4">
  <img src="../images/illustrations/leaf-yellow.png" alt="illustrations" class="bg-shape-5">
  <img src="../images/illustrations/dots-group-cyan.png" alt="illustrations" class="bg-shape-6">
  <img src="../images/illustrations/leaf-cyan-lg.png" alt="illustrations" class="bg-shape-7">
</section>
<!-- /page title -->

<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="font-tertiary mb-3">What should be the proper purpose of UI and UX design?</h3>
        <p class="font-secondary mb-5">Published on May 26, 2017 by <span class="text-primary">uixgeek</span
            class="text-primary"> on <span>UX design</span></p>
        <div class="content">
          <img src="../images/blog/post-1.jpg" alt="post-thumb" class="img-fluid rounded float-left mr-5 mb-4">
          <strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
            mollit anim id est laborum.</strong>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
            dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
            dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem
            ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut
            labore et dolore magnam aliquam quaerat voluptatem.</p>
          <blockquote>Dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi
            tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</blockquote>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
            dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem
            ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut
            labore et dolore magnam aliquam quaerat voluptatem.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- footer -->
<footer class="bg-dark pt-6">
 <div class="section bg-dark text-light py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h4 class="text-light">CityTasks</h4>
          <ul class="list-unstyled">
            <li><a href="whoweare.php" class="text-white-50 small" title="¿Quiénes somos?">¿Quiénes somos?</a></li>
            <li><a href="instructions.php" class="text-white-50 small" title="Cómo funciona">Cómo funciona</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h4 class="text-light">Soporte</h4>
          <ul class="list-unstyled">
            <li><a href="support.php" class="text-white-50 small" title="Centro de ayuda">Centro de ayuda</a></li>
            <li><a href="user-rules.php" class="text-white-50 small" title="Normas de uso">Normas de uso</a></li>
            <li><a href="tips.php" class="text-white-50 small" title="Consejos">Consejos</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h4 class="text-light">Legal</h4>
          <ul class="list-unstyled">
            <li><a href="legal-terms.php" class="text-white-50 small" title="Aviso legal">Aviso legal</a></li>
            <li><a href="use-conditions.php" class="text-white-50 small" title="Condiciones de uso">Condiciones de uso</a></li>
            <li><a href="privacy-policy.php" class="text-white-50 small" title="Política de privacidad">Política de privacidad</a></li>
            <li><a href="cookies-policy.php" class="text-white-50 small" title="Política de Cookies">Política de Cookies</a></li>
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
<script src="../plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<!-- slick slider -->
<script src="../plugins/slick/slick.min.js"></script>
<!-- filter -->
<script src="plugins/shuffle/shuffle.min.js"></script>

<!-- Main Script -->
<script src="../js/script.js"></script>

</body>
</html>