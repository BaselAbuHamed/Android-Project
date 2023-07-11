<?php
require_once 'db.inc.php';

// Retrieve the form inputs
$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];
$email = $_POST['email'];

// Update the password in the database
$sql = "UPDATE student SET password = :password WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_INT);
$stmt->execute();

?>