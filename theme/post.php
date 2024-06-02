<?php 

include 'sessionController.php';


require_once('connection.php');

if (isset($_GET['id'])) {
  $postId = intval($_GET['id']);
  //Consulta para la información del post
  $postStmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
  $postStmt->bindParam(':id', $postId);
  $postStmt->execute();

  $post = $postStmt->fetch(PDO::FETCH_ASSOC);

  //Consulta para la información del usuario que publicó el post
  $userStmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
  $userStmt->bindParam(':username', $post['author']); //Se selecciona el usuario propietario del post
  $userStmt->execute();

  $user = $userStmt->fetch(PDO::FETCH_ASSOC);


  //Consulta para la información del usuario que está viendo el post (el que tiene la sesión iniciada)
  $clientStmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
  $clientStmt->bindParam(':email', $_SESSION['email']); //Se selecciona el usuario con email igual que la sesión
  $clientStmt->execute();

  $client = $clientStmt->fetch(PDO::FETCH_ASSOC);


  //Consulta para obtener los comentarios del post
  $commentStmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = :postId");
  $commentStmt->bindParam(':postId', $post['id']); //Se seleccionan los comentarios pertenecientes al post
  $commentStmt->execute();

  $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);


  //Consulta para obtener las imágenes del post
  $imagesStmt = $pdo->prepare("SELECT * FROM images WHERE post = :postId");
  $imagesStmt->bindParam(':postId', $post['id']); //Se seleccionan las imágenes pertenecientes al post
  $imagesStmt->execute();

  $images = $imagesStmt->fetchAll(PDO::FETCH_ASSOC);

} else{
  echo "<script>alert('Esta oferta no existe');</script>";
  //header('Location: index.php');
}

if($logged){
  $userId = getUserID();
  if($client['username'] == $post['author'] ){
    $proprietary = true;
    
  } else{
    $proprietary = false;
  }
}


try {
  $checkAdminStmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
  $checkAdminStmt->bindParam(':email', $_SESSION['email']);
  $checkAdminStmt->execute();
  $checkAdmin = $checkAdminStmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

// Si el usuario con la sesión iniciada no es ADMIN se le devuelve al index
if($logged){
  if ($checkAdmin['role'] != "ADMIN") {
    $isAdmin = false;
  } else{
    $isAdmin = true;
  }
} else {
  $isAdmin = false;
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
  <title>Publicación</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Creative Portfolio Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Kross Template v1.0">
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

  <style>
   #reportForm {
      display: none; /* Ocultar inicialmente */
    }
    
 .cross {
         padding: 10px;
    color: #d6312d;
    cursor: pointer;
    font-size: 23px;
 }

.cross i{
    
    margin-top: -5px;
    cursor: pointer;
}

.rating {
   display: inline-flex;
    margin-top: -10px;
    flex-direction: row-reverse;
}

.rating>input {
    display: none
}

.rating>label {
    position: relative;
    width: 28px;
    font-size: 35px;
    color: #dbae09;
    cursor: pointer;
}

.rating>label::before {
    content: "\2605";
    position: absolute;
    opacity: 0
}

.rating>label:hover:before,
.rating>label:hover~label:before {
    opacity: 1 !important
}

.rating>input:checked~label:before {
    opacity: 1
}

.rating:hover>input:checked~label:before {
    opacity: 0.4
}

.carousel-image {
  height: 400px; /* Ajusta esto según tus necesidades */
  object-fit: cover;
  object-position: center;
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
<!-- page title -->
<section class="page-title bg-primary position-relative">
  <div class="container">
   
  </div>
  <!-- background shapes -->
  <img src="images/illustrations/page-title.png" alt="illustrations" class="bg-shape-1 w-100">
  <img src="images/illustrations/leaf-pink-round.png" alt="illustrations" class="bg-shape-2">
  <img src="images/illustrations/leaf-orange.png" alt="illustrations" class="bg-shape-4">
  <img src="images/illustrations/leaf-yellow.png" alt="illustrations" class="bg-shape-5">
  <img src="images/illustrations/dots-group-cyan.png" alt="illustrations" class="bg-shape-6">
  <img src="images/illustrations/leaf-cyan-lg.png" alt="illustrations" class="bg-shape-7">
</section>
<!-- /page title -->

<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="font-tertiary mb-3"><?php echo ucfirst($post['title']); ?></h3>  
        <p class="font-secondary mb-5">Publicado a fecha <?php echo $post['pub_date']; ?> por <a href="account.php?id=<?php echo urldecode($user['id']);?>"><?php echo ucfirst($post['author']); ?></a>
        <div class="content">
          <!-- <img src="images/blog/post-1.jpg" alt="post-thumb" class="img-fluid rounded float-left mr-5 mb-4"> -->
          <div class="col-lg-7 mx-auto">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <?php foreach ($images as $index => $image): ?>
                  <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img class="d-block w-100 carousel-image" 
                        src="data:image/jpeg;base64,<?php echo base64_encode($image['image']); ?>" 
                        alt="Slide <?php echo $index + 1; ?>"
                        data-toggle="modal" data-target="#imageModal" 
                        data-src="data:image/jpeg;base64,<?php echo base64_encode($image['image']); ?>">
                  </div>
                <?php endforeach; ?>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>

          <!-- Modal para ampliar la imagen -->
          <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <img id="modalImage" src="" class="img-fluid" alt="Ampliar imagen">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>

          <strong><?php echo ucfirst($post['description']); ?></strong>
          
         

          <!-- Div Con el Mapa de Google Maps, Cambiar la imagen del marker y la posición que cuadre con la de la base de datos -->
          <div class="w-100" style="height: 70vh;">
            <gmp-map center="<?php echo $post['latitude']?>,<?php echo $post['longitude']?>" zoom="14" map-id="DEMO_MAP_ID" style="width: 100%; height: 100%;">
                <gmp-advanced-marker position="<?php echo $post['latitude']?>,<?php echo $post['longitude']?>" title="My location">
                  <img class="flag-icon" src="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"/>
                </gmp-advanced-marker>
            </gmp-map>
          </div>

            <h4 class="font-tertiary mb-3">Información de Contacto</h4>
            <?php
            if($logged){
              ?> 
              <div class="list-group">
                <blockquote>
                  <div class="list-group-item border-0">
                      <h5 class="mb-1">Nombre de Contacto</h5>
                      <p class="mb-1"><?php echo $user['name'] . " " . $user['surname'];?></p>
                    </div>
                    <div class="list-group-item border-0">
                      <h5 class="mb-1">Email</h5>
                      <p class="mb-1">  
                        <a href="mailto:<?php echo $user['email'];?>">
                          <?php echo $user['email'];?>
                        </a>
                      </p>
                    </div>
                </blockquote>
              </div>
              <?php
            }else{
              ?>
              <div class="list-group">
                <div class="list-group-item border-0">
                    <h5 class="mb-3">Inicie Sesión para ver la Información de Contacto</h>
                    <a href="login.php" class="btn btn-primary mt-3">Inicio de Sesión</a>
                </div>
              </div>
              <?php
            }
            ?>

        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h4 class="font-weight-bold mb-3">Comentarios</h4>
        <div class="bg-gray p-5 mb-4">

        <?php 
        if(empty($comments)){
          echo "<h5 class='text-center'>Aún no hay comentarios...</h5>";
        }

        foreach($comments as $comment){
          ?>
        <div class="media border-bottom py-4">
          <img src="images/user-1.jpg" class="img-fluid align-self-start rounded-circle mr-3" alt="">
          <div class="media-body">
            <h5 class="mt-0"><?php echo $comment['author']; ?></h5>
            <p><?php echo $comment['pub_date'];  ?></p>
            <p><?php echo $comment['comment']; ?></p>
            <p> <?php
            for($i = 0; $i < $comment['rating']; $i++ ){
              echo  "☆";
            }

            if($comment['author'] == $client['username']){
              echo '<a href="deleteComment.php?id=' . $comment['id'] . '&postId=' . $postId . '" onclick="return confirm(\'¿Estás seguro de que quieres eliminar este comentario?\')">Eliminar comentario</a>';

            }
            ?></p>
          </div>
        </div>

        <?php
        }
        ?>
        </div>

        <?php if($logged && !$proprietary ){ ?>
        <!--Leave a Comment Section-->
        <div class="mt-5">
          <h4 class="font-weight-bold mb-3 border-bottom pb-3">¿Has contratado este servicio? Deja una reseña</h4>

          <form method="post" action="uploadComment.php" class="row">
            <div class="col-md-12">
              
              <input type="hidden" name="author" value="<?php echo $client['username']; ?>">
              <input type="hidden" name="postId" value="<?php echo $post['id']; ?>">
              <textarea name="comment" id="comment" placeholder="Comentario..." class="form-control mb-4"></textarea required>

              <div class="rating"> 
                <input type="radio" name="rating" value="5" id="5" required><label for="5">☆</label> 
                <input type="radio" name="rating" value="4" id="4" required><label for="4">☆</label> 
                <input type="radio" name="rating" value="3" id="3" required><label for="3">☆</label> 
                <input type="radio" name="rating" value="2" id="2" required><label for="2">☆</label> 
                <input type="radio" name="rating" value="1" id="1" required><label for="1">☆</label> 
              </div>
              <button type="submit" class="btn btn-primary w-100">Enviar Comentario</button>
            </div>
          </form>
        </div>
        <?php
              }     ?>
      </div>
    </div>
  </div>
</section> 

<!-- blog -->
<section class="section">
  <div class="container">
  
    <?php 
    if($logged){
      echo '<button id="toggleFormButton" class="btn btn-danger btn-sm">Denunciar Publicación</button>';
    }
   ?>
  </div>
</section>
<!-- /blog -->

<!-- report Form -->
<section class="section section-on-footer mb-1" >
<!-- Contenedor del formulario de contacto -->
<div id="reportForm" class="container mt-5">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="bg-white rounded text-center p-5 shadow-down">
        <h4 class="mb-80">Denunciar Publicación</h4>
        <form method="post" action="reportPost.php" class="row">
          <select name="cause" id="cause" class="form-control px-0 mb-4" required>
            <option value="">--Seleccione un Motivo--</option>
            <option value="0">Timo o Estafa</option>
            <option value="1">Contenido Explícito</option>
            <option value="2">Publicación Duplicada</option>
            <option value="3">Publicidad o Spam</option>
            <option value="4">Servicio Prohibido</option>
            <option value="5">La imagen no coincide</option>
           
          </select>
          <div class="col-12">
            <textarea name="message" id="message" class="form-control px-0 mb-4" placeholder="Inserte información adicional." required></textarea>
          </div>
          <div class="col-lg-6 col-10 mx-auto">
            <button class="btn btn-danger w-100 mb-4">Denunciar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>
<!-- /report Form -->

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

<!-- Google Maps JS Api -->
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCytHnzo5om-vHBXOza2eUzcSo9Di3l68M&callback=console.debug&libraries=maps,marker&v=beta">
    </script>

<script>
  // Utiliza jQuery para gestionar el evento del modal
  $('#imageModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que activa el modal
    var src = button.data('src') // Extrae la URL de la imagen
    var modal = $(this)
    modal.find('#modalImage').attr('src', src)
  })
</script>

<script>
 document.getElementById('toggleFormButton').addEventListener('click', function(event) {
    event.preventDefault();
    var formContainer = document.getElementById('reportForm');
    var toggleButton = document.getElementById('toggleFormButton');
    
    if (formContainer.style.display === 'none' || formContainer.style.display === '') {
      formContainer.style.display = 'block';
      toggleButton.classList.remove('btn-primary');
      toggleButton.classList.add('btn-danger');
      toggleButton.textContent = 'Cancelar';
    } else {
      formContainer.style.display = 'none';
      toggleButton.classList.remove('btn-danger');
      toggleButton.classList.add('btn-primary');
      toggleButton.textContent = 'Denunciar Publicación';
    }
  });
</script>


</body>
</html>