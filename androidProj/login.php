<?php
require 'db.inc.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM student WHERE email ='$email' AND password = '$password' LIMIT 1";
    $statement = $pdo->query($query);

    if ($statement->rowCount() > 0) {
        // Fetch the student record
        $student = $statement->fetch(PDO::FETCH_ASSOC);

        // Return the student data in JSON format
        header('Content-Type: application/json');
        echo json_encode($student);
    } else {
        // Invalid login
        $error = "Invalid email or password";
        echo $error;
    }
}

?>
