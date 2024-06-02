<?php
include 'sessionController.php';

if ($logged) {
    
    require 'connection.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtén los datos del formulario
        $accountId = intval($_POST['accountId']);
        $confirm = $_POST['confirm'];
    
        // Verifica que el usuario haya escrito "CONFIRMAR"
        if ($confirm === 'CONFIRMAR') {
            try {
                // Preparar la consulta SQL para eliminar la cuenta
                $sql = "DELETE FROM users WHERE id = :accountId";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);
    
                // Ejecutar la consulta
                $stmt->execute();
    
                // Redirigir o mostrar un mensaje de éxito
                require('logout.php');
                header('Location: index.php'); // Redirigir a la página principal después de eliminar la cuenta
                exit();
            } catch (PDOException $e) {
                // Manejar los errores de la base de datos
                echo "Error: " . $e->getMessage();
            }
        } else {
            // Si el texto no es "CONFIRMAR", redirigir a account.php con el accountId
           
            header('Location: account.php?id=' . $accountId);
            exit();
        }
    } else {
        // Redirigir si el acceso no es vía POST
        
        header('Location: index.php'); // Redirigir a la página principal si el método no es POST
        exit();
    }
    
} else{
    header('Location: index.php');
    echo "ERROR 3";
    exit();
}


?>