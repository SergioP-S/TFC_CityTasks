<?php 
//
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $author = $_POST['author'];
    $postId = $_POST['postId'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // Valida los datos si es necesario

    try {
        // Preparar la consulta SQL con marcadores
        $sql = "INSERT INTO comments (author, post_id, comment, rating, pub_date) VALUES (:author, :post_id, :comment, :rating, NOW())";
        $commentStmt = $pdo->prepare($sql);

        // Vincular los valores a los marcadores
        $commentStmt->bindParam(':author', $author, PDO::PARAM_STR);
        $commentStmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $commentStmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $commentStmt->bindParam(':rating', $rating, PDO::PARAM_INT);

        // Ejecutar la consulta
        $commentStmt->execute();

        // Redirigir o mostrar un mensaje de éxito
        header('Location: post.php?id=' . $postId);
    } catch (PDOException $e) {
        // Manejar los errores de la base de datos
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirigir si el acceso no es vía POST
    header('Location: index.php');    
    exit();
}
?>