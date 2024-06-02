<?php
if (!isset($_COOKIE['cookiesAccepted_CityTasks'])) {
    echo '
    <div class="d-flex justify-content-center align-items-center my-0" id="formulario">
    <form method="post" action="cookieBanner.php" class="d-flex justify-content-center align-items-center">
        <p class="mb-0 px-2">Este sitio web utiliza cookies para mejorar la experiencia del usuario. Si continúa utilizando nuestra web, significa que está de acuerdo con nuestra <a href="privacy-policy.php">Política de Privacidad</a>.</p>
        <input type="hidden" name="accept_cookies" value="true">
        <button type="submit" class="btn btn-primary btn-sm ml-3">De Acuerdo</button>
    </form>
  </div>';
    
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $todayDate = date("Y-m-d");
    
    // Crear la cookie con la fecha de hoy y que expira en 1 año
    setcookie('cookiesAccepted_CityTasks', $todayDate, time() + (365 * 24 * 60 * 60), "/"); // 1 año

    // Redirigir para evitar reenvío del formulario
    header("Location: index.php");
    exit();
}

// SELECT * FROM moz_cookies WHERE name = 'cookiesAccepted_CityTasks';
// DELETE FROM moz_cookies WHERE name = 'cookiesAccepted_CityTasks';

?>