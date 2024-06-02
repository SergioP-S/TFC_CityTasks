<?php
require_once('connection.php'); // Incluir el archivo de conexión
require_once('sessionController.php');
require_once('adminController.php');
//Redirigir al index en caso de que se intente acceder sin una sesión



if ($_SERVER["REQUEST_METHOD"] == "GET") {
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $postId = intval($_GET['id']);

    // Verificar si el usuario ha iniciado sesión
    if ($logged) {
        $accountId = getUserID();

        try {
            // Consulta para verificar la propiedad del post
            $postStmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
            $postStmt->bindParam(':id', $postId, PDO::PARAM_INT);
            $postStmt->execute();
            $post = $postStmt->fetch(PDO::FETCH_ASSOC);

            //Consulta para la información que tiene la sesion iniciada 
            $userStmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $userStmt->bindParam(':id', $accountId); //Se selecciona el usuario propietario del post
            $userStmt->execute();
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);
            

            if ($post['author'] == $user['username']) {
                // El post pertenece al usuario autenticado
                $title = $post['title'];
                $description = $post['description'];
                $category = $post['category'];
                $latitude = $post['latitude'];
                $longitude = $post['longitude'];
                

                $imageQuery = "SELECT * FROM images WHERE post = :id";
                $imageStmt = $pdo->prepare($imageQuery);
                $imageStmt->bindParam(':id', $postId, PDO::PARAM_INT);
                $imageStmt->execute();
                $images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // El post no pertenece al usuario o no existe
                echo "<script>alert('Esta oferta no es tuya o no existe');</script>";
                //header('Location: index.php');
                exit;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // El usuario no ha iniciado sesión
        echo "<script>alert('Debes iniciar sesión para editar esta oferta');</script>";
        //header('Location: login.php');
        exit;
    }
} else {
    // ID del post no proporcionado o inválido
    echo "<script>alert('Oferta no válida');</script>";
    //header('Location: index.php');
    exit;
}
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del post y otros datos del formulario
    $postId = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];


    try {
        // Iniciar una transacción
        $pdo->beginTransaction();

        // Eliminar todas las imágenes anteriores del post
        $deleteQuery = "DELETE FROM images WHERE post = :postId";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->bindParam(':postId', $postId, PDO::PARAM_INT);
        $deleteStmt->execute();

        // Actualizar los datos del post
        $updateQuery = "UPDATE posts SET title = :title, description = :description, category = :category, latitude = :latitude, longitude = :longitude WHERE id = :postId";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':title', $title, PDO::PARAM_STR);
        $updateStmt->bindParam(':description', $description, PDO::PARAM_STR);
        $updateStmt->bindParam(':category', $category, PDO::PARAM_STR);
        $updateStmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
        $updateStmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);
        $updateStmt->bindParam(':postId', $postId, PDO::PARAM_INT);
        $updateStmt->execute();

        // Guardar las nuevas imágenes
        if (isset($_FILES['images']) && count($_FILES['images']['tmp_name']) > 0) {
            $insertImageQuery = "INSERT INTO images (post, image) VALUES (:postId, :image)";
            $insertImageStmt = $pdo->prepare($insertImageQuery);

            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
                    $imageData = file_get_contents($tmp_name);
                    $insertImageStmt->bindParam(':postId', $postId, PDO::PARAM_INT);
                    $insertImageStmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
                    $insertImageStmt->execute();
                }
            }
        }

        // Confirmar la transacción
        $pdo->commit();
        header('Location: index.php');   
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $pdo->rollBack();
        echo "Error al guardar los cambios: " . $e->getMessage();
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
  <title>Editar Publicación</title>

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
          <a class='nav-link' href='account.php?id=" . $accountId ."'>Mi Cuenta</a>
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
        <h1 class="text-white font-tertiary">Editar Servicio</h1>
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
<section class="section section-on-footer" data-background="images/backgrounds/bg-dots.png">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="section-title">Modificar Servicio</h2>
            </div>
            <div class="col-lg-8 mx-auto">
                <div class="bg-white rounded text-center p-5 shadow-down">
                    <h4 class="mb-80">Modificar un Servicio</h4>
                    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row" onsubmit="return validateForm()">
                        <input type="hidden" name="id" value="<?php echo $postId; ?>">
                        <div class="col-md-12">
                            <input type="text" id="title" name="title" placeholder="Título" class="form-control px-0 mb-4" value="<?php echo htmlspecialchars($title); ?>" required>
                        </div>
                        <div class="col-12">
                            <textarea name="description" id="description" class="form-control px-0 mb-4" placeholder="Descripción del Servicio" required><?php echo htmlspecialchars($description); ?></textarea>
                        </div>
                        <select id="category" name="category" class="form-control form-select-lg mb-3" required>
                            <option value="">--Seleccione una Categoría--</option>
                            <?php
                            require_once('categories.php');
                            foreach ($categories as $cat) {
                                $selected = ($cat == $category) ? 'selected' : '';
                                echo "<option value='$cat' $selected>$cat</option>";
                            }
                            ?>
                        </select>


                        <div class="col-12" style="height: 70vh;">
                            <p>Nota: La ubicación se actualizará a la nueva insertada.</p>
                            <div id="map"></div>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCytHnzo5om-vHBXOza2eUzcSo9Di3l68M&callback=initMap&v=weekly&solution_channel=GMP_CCS_geocodingservice_v1" defer></script>
                            <input id="latitude" type="decimal" name="latitude" hidden value="<?php echo htmlspecialchars($latitude); ?>" required>
                            <input id="longitude" type="decimal" name="longitude" hidden value="<?php echo htmlspecialchars($longitude); ?>" required>
                        </div>

                        <div class="col-12">
                            <input type="text" id="location" name="location" placeholder="Localización" class="form-control px-0 mb-4" disabled required>
                        </div>

                        <div class="col-12">
                            <label for="images">Selecciona hasta 6 imágenes (Se reemplazarán por las ya existentes.):</label>
                            <input type="file" name="images[]" id="images" multiple accept="image/*" onchange="validateFileInput()"><br><br>
                            <?php
                            ?>
                        </div>

                        <div class="col-12">
                            <input type="submit" id="submit" class="btn btn-primary w-40" value="Guardar Cambios">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /contact -->

<!-- footer -->
<footer class="bg-dark footer-section">
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5 class="text-light">Email</h5>
          <p class="text-white paragraph-lg font-secondary">steve.fruits@email.com</p>
        </div>
        <div class="col-md-4">
          <h5 class="text-light">Phone</h5>
          <p class="text-white paragraph-lg font-secondary">+880 2544 658 256</p>
        </div>
        <div class="col-md-4">
          <h5 class="text-light">Address</h5>
          <p class="text-white paragraph-lg font-secondary">125/A, CA Commercial Area, California, USA</p>
        </div>
      </div>
    </div>
  </div>
  <div class="border-top text-center border-dark py-5">
    <p class="mb-0 text-light">Copyright &copy;<script>
        var CurrentYear = new Date().getFullYear()
        document.write(CurrentYear)
      </script> Designed &amp; Developed by <a class="text-white-50" href="Themefisher">Themefisher</a></p>
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