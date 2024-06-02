<?php
// Configurar parámetros de la cookie de sesión
$lifetime = 20160; //14 días en segundos
$path = '/';
$domain = ''; // No especificar el dominio
$secure = false; // False si no estás usando HTTPS
$httponly = true; // True para prevenir acceso vía JavaScript

session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);

// Función para iniciar la sesión
function startSession() {
    
    session_start();
    session_regenerate_id(true);
}

// Función para comprobar si el usuario está logueado
function isUserLoggedIn() {
    return isset($_SESSION['email']);
}

// Función para establecer datos de usuario en la sesión
function setUserSession($email) {
    $_SESSION['email'] = $email;
}

// Función para destruir la sesión del usuario
function logout() {
    session_unset();
    session_destroy();
}

function getUserID(){
    if(isset($_SESSION['email'])){
    include('connection.php');
    try {
        $checkUserStmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $checkUserStmt->bindParam(':email', $_SESSION['email']);
        $checkUserStmt->execute();
        $checkUser = $checkUserStmt->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

      $userId = $checkUser['id'];

    } else{
        $userId = null;
    }

    return $userId;
}

// Iniciar la sesión automáticamente al incluir este archivo
startSession();

// Comprobar si el usuario está logueado
$logged = isUserLoggedIn();


?>
