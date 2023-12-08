<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $status = $_POST['status'];
    $role = $_POST['role'];

    
    $updateQuery = "UPDATE `client` SET `name`='$name', `lastname`='$lastname', `status`='$status', `role`='$role' WHERE `id`='$userId'";
    $updateResult = mysqli_query($induction, $updateQuery);

    if ($updateResult) {
       
        $selectQuery = "SELECT * FROM `client` WHERE `id`='$userId'";
        $selectResult = mysqli_query($induction, $selectQuery);

        if ($selectResult) {
            $userData = mysqli_fetch_assoc($selectResult);

           header('Content-Type: application/json');
            echo json_encode($userData);
        } else {
            echo 'Error selecting user: ' . mysqli_error($induction);
        }
    } else {
        echo 'Error updating user: ' . mysqli_error($induction);
    }
} else {
    echo 'Invalid request';
}
?>
