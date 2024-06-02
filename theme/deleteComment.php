<?php
include 'sessionController.php';

if ($logged) {
    // Verificar si se ha recibido el ID del comentario a eliminar
    if (isset($_GET['id'])) {
        $postId = $_GET['postId'];
        // Incluir archivo de conexión a la base de datos
        require 'connection.php';
        $commentId = $_GET['id'];

        //Consulta para obtener los comentarios del post
        $commentStmt = $pdo->prepare("SELECT * FROM comments WHERE id = :commentId");
        $commentStmt->bindParam(':commentId', $commentId); //Se seleccionan los comentarios pertenecientes al post
        $commentStmt->execute();

        $comment = $commentStmt->fetch(PDO::FETCH_ASSOC);
       

        $clientId = getUserID();
          //Consulta para la información del usuario que está viendo el post (el que tiene la sesión iniciada)
        $clientStmt = $pdo->prepare("SELECT * FROM users WHERE id = :userId");
        $clientStmt->bindParam(':userId', $clientId); //Se selecciona el usuario con email igual que la sesión
        $clientStmt->execute();

        $client = $clientStmt->fetch(PDO::FETCH_ASSOC);
        echo "Cliente:". $client['username'];   //PROBLEMA AQUI 
        echo "AUTHOR:" .  $comment['author'];
        if($client['username'] == $comment['author']){
            try {



                // Preparar la consulta SQL para eliminar el comentario
                $sql = "DELETE FROM comments WHERE id = :id";
                $stmt = $pdo->prepare($sql);
    
                // Vincular el parámetro del ID del comentario
                $stmt->bindParam(':id', $commentId, PDO::PARAM_INT);
    
                // Ejecutar la consulta
                $stmt->execute();
    
                // Redirigir a alguna página de éxito o al post desde el que se eliminó el comentario
                header('Location: post.php?id=' . $postId);
                exit();
            } catch (PDOException $e) {
                // Manejar errores de la base de datos
                echo "Error: " . $e->getMessage();
            }
        } else{
            //header('Location: index.php');
            echo "ERROR 1";
            exit();
        }
    } else {
        // Si no se proporcionó un ID de comentario, redirigir a alguna página de error
        //header('Location: index.php');
        echo "ERROR 2";
        exit();
    }
} else{
    //header('Location: index.php');
    echo "ERROR 3";
    exit();
}


?>