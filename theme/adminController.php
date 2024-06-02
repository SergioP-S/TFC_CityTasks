<?php 
if(isset($_SESSION['email'])){
    require_once('connection.php');
    try {
        $checkAdminStmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $checkAdminStmt->bindParam(':email', $_SESSION['email']);
        $checkAdminStmt->execute();
        $checkAdmin = $checkAdminStmt->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

    if ($checkAdmin['role'] != "ADMIN") {
    $isAdmin = false;
    } else{
    $isAdmin = true;
    }

} else{
    $isAdmin = false;
}