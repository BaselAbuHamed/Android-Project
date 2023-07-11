<?php
function moveFile($fileToMove, $destination, $fileType)
{
    $validEXT = array("pdf");

    $validMime = array("application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf");

    $components = explode(".", $destination);

    $extension = end($components);

    if (in_array($fileType, $validMime) && in_array($extension, $validEXT)) {
        echo $destination . ' Uploaded successfully<br>';
        move_uploaded_file($fileToMove, "files/" . $destination) or die("Error moving file");
        return "files/" . $destination;
    } else {
        echo 'Invalid file type= ' . $fileType . ' Extension=' . $extension . "<br>";
        return null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requiredKeys = array('user_id', 'course_id', 'name', 'file');

    foreach ($requiredKeys as $key) {
        if (!isset($_POST[$key])) {
            die("Error: Required key '$key' is missing.");
        }
    }

    $user_id = $_POST['user_id'];
    $course_id = $_POST['course_id'];
    $name = $_POST['name'];

    $filePath = '';
    if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $clientName = $_FILES["file"]["name"];
        $serverName = $_FILES["file"]["tmp_name"];
        $fileType = $_FILES["file"]["type"];
        $filePath = moveFile($_FILES["file"]["tmp_name"], $_FILES["file"]["name"], $_FILES["file"]["type"]);

        if ($filePath === null) {
            die("Error: Invalid file type or extension.");
        }
    }

    echo $user_id . "\n";
    echo $course_id . "\n";
    echo $name . "\n";

    require 'db.inc.php';

    try {
        $stmt = $pdo->prepare("INSERT INTO file (student_id, course_id, path, name) 
                              VALUES (:user_id, :course_id, :filePath, :name)");

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':filePath', $filePath);
        $stmt->bindParam(':name', $name);

        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "File uploaded and added to the database successfully";
        } else {
            echo "Error uploading file";
        }
    } catch (PDOException $e) {
        die("Error uploading file: " . $e->getMessage());
    }

    exit();
}
?>
