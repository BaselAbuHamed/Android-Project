<?php
require_once 'db.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $major = $_POST['major'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("INSERT INTO student (name, specialization, email, password) VALUES (:name, :specialization, :email, :password)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':specialization', $major);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $affectedRows = $stmt->rowCount();

    if ($affectedRows > 0) {
        echo "Signed up successfully";
        
    } else {
        echo "Failed to sign up";
    }
}
?>
