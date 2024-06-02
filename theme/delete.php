<?php
require 'sessionController.php';  // Asegúrate de que este archivo maneja la lógica de sesiones
require 'connection.php';  // Archivo que maneja la conexión a la base de datos usando PDO


if ($logged) {
    $email = $_SESSION['email'];  // Asumiendo que el email se guarda en la sesión

    // Obtener el username a partir del email
    $stmt = $pdo->prepare("SELECT id,username FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = $user['username'];

        if (isset($_GET['id'])) {
            $post_id = intval($_GET['id']);
            
            // Obtener el autor del post
            $stmt = $pdo->prepare("SELECT author FROM posts WHERE id = :id");
            $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $author = $row['author'];
                
                if ($author === $username) {
                    // Borrar el post
                    $delete_stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
                    $delete_stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
                    $delete_stmt->execute();

                    if ($delete_stmt->rowCount() === 1) {
                        echo "Post borrado exitosamente.";
                        header('Location: account.php?id=' . $user['id']);


                    } else {
                        echo "Error al borrar el post.";
                    }
                } else {
                    echo "No tienes permisos para borrar este post.";
                }
            } else {
                echo "Post no encontrado.";
            }
        } else {
            echo "ID de post no especificado.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "No estás autenticado.";
}
?>
