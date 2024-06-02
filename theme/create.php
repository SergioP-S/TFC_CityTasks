<?php
require_once('connection.php'); // Incluir el archivo de conexión
include 'sessionController.php';

require_once('adminController.php');

$userId = getUserID();
if ($_SERVER["REQUEST_METHOD"] == "POST") {



     // Obtener el correo electrónico de la sesión
     $email = $_SESSION['email'];
     // Consulta SQL para obtener el nombre de usuario
     $sql = "SELECT username FROM users WHERE email = :email";
     try {
         // Preparar la consulta
         $stmt = $pdo->prepare($sql);
         // Asignar valor al marcador de posición
         $stmt->bindParam(':email', $email, PDO::PARAM_STR);
         // Ejecutar la consulta
         $stmt->execute();
         // Obtener el resultado
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         // Verificar si se encontró el nombre de usuario
         if ($row) {
             $username = $row['username'];
             echo "El nombre de usuario asociado al correo electrónico $email es: $username";
         } else {
             echo "No se encontró ningún nombre de usuario asociado al correo electrónico $email";
         }
     } catch (PDOException $e) {
         // Manejo de errores
         die("Error al realizar la consulta: " . $e->getMessage());
     }

    // Recibir datos del formulario
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    
    // Obtener la fecha actual
    //$pub_date = date('d-m-Y'); // Formato: Año-Mes-Día Hora:Minuto:Segundo
    $pub_date = date('Y-m-d');
    // Consulta SQL para insertar datos
    $sql = "INSERT INTO posts (title, description, author, category, latitude, longitude, pub_date) VALUES (:title, :description, :author, :category, :latitude, :longitude, :pub_date)";

    try {
        // Preparar la consulta
        $stmt = $pdo->prepare($sql);

        // Asignar valores a los marcadores de posición
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':author', $username, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
        $stmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);
        $stmt->bindParam(':pub_date', $pub_date, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Mensaje de éxito
        //echo "<script> alert('Registro insertado correctamente.');</script>";
        header('Location: index.php');   
    } catch (PDOException $e) {
        // Manejo de errores
        die("Error al insertar el registro: " . $e->getMessage());
    }


    //subida de imagenes a la tabla images
    try{
      if (isset($_FILES['images'])){

        echo "ENTRANDO EN EL BUCLE DE LAS IMAGENES";
        $postId = $pdo->lastInsertId();

        $imageCount = count($_FILES['images']['name']);

        if ($imageCount > 6) {
            echo "No puedes subir más de 6 imágenes.";
            exit;
        }
        $sql = "INSERT INTO images (image, post) VALUES (:imagen, :postId)";
        $imageStmt = $pdo->prepare($sql);

        for ($i = 0; $i < $imageCount; $i++) {
          $image = $_FILES['images']['tmp_name'][$i];
          $imgContent = file_get_contents($image);

          $imageStmt->bindParam(':postId', $postId);
          $imageStmt->bindParam(':imagen', $imgContent, PDO::PARAM_LOB);

          if ($imageStmt->execute() !== TRUE) {
              echo "Error: " . $imageStmt->errorInfo()[2];
              exit;
          }
        }
      }
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
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
  <title>Publicar Servicio</title>

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

  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script>
      /**
       * @license
       * Copyright 2019 Google LLC. All Rights Reserved.
       * SPDX-License-Identifier: Apache-2.0
       */
      let map;
      let marker;
      let geocoder;
      let responseDiv;
      let response;

      function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 8,
          center: { lat: 40.37, lng: -3.75 },
          mapTypeControl: false,
        });
        geocoder = new google.maps.Geocoder();

        const inputText = document.createElement("input");

        inputText.type = "text";
        inputText.placeholder = "Enter a location";
        inputText.id = "inputText"

        const submitButton = document.createElement("input");

        submitButton.type = "button";
        submitButton.value = "Buscar";
        submitButton.id = "submitButton";
        submitButton.classList.add("button", "button-primary");

        const clearButton = document.createElement("input");

        clearButton.type = "button";
        clearButton.value = "Limpiar";
        clearButton.id = "clearButton"
        clearButton.classList.add("button", "button-secondary");
      

        const instructionsElement = document.createElement("p");

        instructionsElement.id = "instructions";
        instructionsElement.innerHTML =
          "<strong>Instrucciones</strong>: Introduzca una dirección o seleccionela en el mapa.";
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(clearButton);
        map.controls[google.maps.ControlPosition.LEFT_TOP].push(
          instructionsElement
        );
        map.controls[google.maps.ControlPosition.LEFT_TOP].push(responseDiv);
        marker = new google.maps.Marker({
          map,
        });
        map.addListener("click", (e) => {
          geocode({ location: e.latLng });
        });
        submitButton.addEventListener("click", () =>
          geocode({ address: inputText.value })
        );
        clearButton.addEventListener("click", () => {
          clear();
        });
        clear();
      }

      function clear() {
        marker.setMap(null);
      }

    function geocode(request) {
  clear();
  geocoder
    .geocode(request)
    .then((result) => {
      const { results } = result;

      if (results.length > 0) {
        const location = results[0].geometry.location;
        const lat = location.lat();
        const lng = location.lng();
        const address = results[0].formatted_address;

        const showAddress =document.getElementById('location');
        showAddress.value =address;
        

        map.setCenter(location);
        marker.setPosition(location);
        marker.setMap(map);
        
        latitudeValue = document.getElementById('latitude')
        latitudeValue.value = lat;

        longitudeValue = document.getElementById('longitude')
        longitudeValue.value = lng;



        console.log("Latitude: " + lat);
        console.log("Longitude: " + lng);
        console.log("Format Address: " + address);

      } else {
        console.log("No results found");
      }

      return results;
    })
    .catch((e) => {
      alert("Geocode was not successful for the following reason: " + e);
    });
}






      window.initMap = initMap;

  
      
    </script>
    <style>
      /**
       * @license
       * Copyright 2019 Google LLC. All Rights Reserved.
       * SPDX-License-Identifier: Apache-2.0
       */
      /**
       * Always set the map height explicitly to define the size of the div element
       * that contains the map. 
       */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #inputText{
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        margin: 10px;
        padding: 0 0.5em;
        font: 400 18px Roboto, Arial, sans-serif;
        overflow: hidden;
        line-height: 40px;
        margin-right: 0;
        min-width: 25%;
      }

      #submitButton,
      #clearButton {
          background-color: #fff;
          border: 0;
          border-radius: 2px;
          box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
          margin: 10px;
          padding: 0 0.5em;
          font: 400 18px Roboto, Arial, sans-serif;
          overflow: hidden;
          height: 40px;
          cursor: pointer;
          margin-left: 5px;
      }
      #submitButton,
      #clearButton:hover  {
        background: rgb(235, 235, 235);
      }
      #submitButton{
        background-color: #1a73e8;
        color: white;
      }
      #submitButton:hover {
        background-color: #1765cc;
      }
      #clearButton{
        background-color: white;
        color: #1a73e8;
      }
      #clearButton:hover {
        background-color: #d2e3fc;
      }

      #response-container {
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        margin: 10px;
        padding: 0 0.5em;
        font: 400 18px Roboto, Arial, sans-serif;
        overflow: hidden;
        overflow: auto;
        max-height: 50%;
        max-width: 90%;
        background-color: rgba(255, 255, 255, 0.95);
        font-size: small;
      }

      #instructions {
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        margin: 10px;
        padding: 0 0.5em;
        font: 400 18px Roboto, Arial, sans-serif;
        overflow: hidden;
        padding: 1rem;
        font-size: medium;
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
    <div class="row">
      <div class="col-12 text-center">
        <h1 class="text-white font-tertiary">Publicar Servicio</h1>
      </div>
    </div>
  </div>
  <!-- background shapes -->
  <img src="images/illustrations/page-title.png" alt="illustrations" class="bg-shape-1 w-100">
  <img src="images/illustrations/leaf-pink-round.png" alt="illustrations" class="bg-shape-2">
  <img src="images/illustrations/dots-cyan.png" alt="illustrations" class="bg-shape-3">
  <img src="images/illustrations/leaf-orange.png" alt="illustrations" class="bg-shape-4">
  <img src="images/illustrations/leaf-yellow.png" alt="illustrations" class="bg-shape-5">
  <img src="images/illustrations/dots-group-cyan.png" alt="illustrations" class="bg-shape-6">
  <img src="images/illustrations/leaf-cyan-lg.png" alt="illustrations" class="bg-shape-7">
</section>
<!-- /page title -->

<!-- contact -->
<section class="section" data-background="images/backgrounds/bg-dots.png">
  <div class="container">
    <div class="row">
      
      <div class="col-lg-8 mx-auto">
        <div class="bg-white rounded text-center p-5 shadow-down">
          <h4 class="mb-80">Rellene el formulario para publicar un servicio. Consulte la página de <a href="footer-pages/tips.php">Consejos</a></h4>
          <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row" onsubmit="return validateForm()">
            <div class="col-md-12">
                <input type="text" id="title" name="title" placeholder="Título" class="form-control px-0 mb-4" required>
            </div>
            <div class="col-12">
                <textarea name="description" id="description" class="form-control px-0 mb-4" placeholder="Descripción del Servicio" required></textarea>
            </div>
            <select id="category" name="category" class="form-control form-select-lg mb-3" required>
                <option value="">--Seleccione una Categoría--</option> <!-- Opción default -->
                <?php
                require_once('categories.php');
                
                foreach($categories as $category){
                    echo "<option value='$category'>$category</option>";
                }
                ?>
            </select>
          
            <div class="col-12" style="height: 70vh;">
                <div id="map"></div>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCytHnzo5om-vHBXOza2eUzcSo9Di3l68M&callback=initMap&v=weekly&solution_channel=GMP_CCS_geocodingservice_v1" defer>
                </script>

                <input id="latitude" type="decimal" name="latitude" hidden required> 
                <input id="longitude" type="decimal" name="longitude" hidden required> 
            </div>

            <div class="col-12">
                <input type="text" id="location" name="location" placeholder="Localización" class="form-control px-0 mb-4" disabled required>
            </div>

            <div class="col-12">
                <label for="images">Selecciona hasta 6 imágenes:</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*" required onchange="validateFileInput()"><br><br>
            </div>

            <div class="col-12">
                <input type="submit" id="submit" class="btn btn-primary w-40" value="Publicar">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /contact -->

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

<script>
        function validateFileInput() {
            var fileInput = document.getElementById('images');
            var fileCount = fileInput.files.length;
            if (fileCount > 6) {
                alert("No puedes subir más de 6 imágenes.");
                fileInput.value = ''; // Clear the input
            }
        }
</script>

<!-- Google Maps Api JS -->


</body>
</html>