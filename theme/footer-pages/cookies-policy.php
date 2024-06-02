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
        <h1 class="text-white font-tertiary">Política de Cookies</h1>
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
        <h2 class="font-tertiary mb-3">Política de Cookies</h2>
        <div class="content">
          <p>El acceso a este Sitio Web puede implicar la utilización de cookies. Las cookies son pequeñas cantidades de 
          información que se almacenan en el navegador utilizado por cada Usuario —en los distintos dispositivos que pueda
          utilizar para navegar— para que el servidor recuerde cierta información que posteriormente y únicamente el 
          servidor que la implementó leerá. Las cookies facilitan la navegación, la hacen más amigable, y no dañan 
          el dispositivo de navegación.</p>
          <p>Las cookies son procedimientos automáticos de recogida de información relativa a las preferencias determinadas
          por el Usuario durante su visita al Sitio Web con el fin de reconocerlo como Usuario, y personalizar su experiencia 
          y el uso del Sitio Web, y pueden también, por ejemplo, ayudar a identificar y resolver errores.</p>
          <p>La información recabada a través de las cookies puede incluir la fecha y hora de visitas al Sitio Web, 
          las páginas visionadas, el tiempo que ha estado en el Sitio Web y los sitios visitados justo antes y 
          después del mismo. Sin embargo, ninguna cookie permite que esta misma pueda contactarse con el número
          de teléfono del Usuario o con cualquier otro medio de contacto personal. Ninguna cookie puede extraer 
          información del disco duro del Usuario o robar información personal. La única manera de que la información
          privada del Usuario forme parte del archivo Cookie es que el usuario dé personalmente esa información
          al servidor.</p>
          <h4>Cookies propias</h4>
          <p>Son aquellas cookies que son enviadas al ordenador o dispositivo del Usuario y gestionadas exclusivamente 
          por CityTasks - Servicios de Barrio para el mejor funcionamiento del Sitio Web. La información que se recaba 
          se emplea para mejorar la calidad del Sitio Web y su Contenido y su experiencia como Usuario. Estas cookies
          permiten reconocer al Usuario como visitante recurrente del Sitio Web y adaptar el contenido para ofrecerle
          contenidos que se ajusten a sus preferencias.</p>
          <h4>Deshabilitar, rechazar y eliminar cookies</h4>
          <p>El Usuario puede deshabilitar, rechazar y eliminar las cookies —total o parcialmente— instaladas en su 
          dispositivo mediante la configuración de su navegador (entre los que se encuentran, por ejemplo, 
          Chrome, Firefox, Safari, Explorer). En este sentido, los procedimientos para rechazar y eliminar 
          las cookies pueden diferir de un navegador de Internet a otro. En consecuencia, el Usuario debe
          acudir a las instrucciones facilitadas por el propio navegador de Internet que esté utilizando. 
          En el supuesto de que rechace el uso de cookies —total o parcialmente— podrá seguir usando el 
          Sitio Web, si bien podrá tener limitada la utilización de algunas de las prestaciones del mismo.</p>
          <p>Este documento de Política de Cookies ha sido creado mediante el generador de plantilla de política de cookies web gratis online el día 01/06/2024.</p>
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