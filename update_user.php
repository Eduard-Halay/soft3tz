<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $status = $_POST['status'];
    $role = intval($_POST['role']);

    
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
            echo '{status: false, error:{code: 101, message: "Error selecting user"}} . mysqli_error($induction)';
        }
    } else {
        echo '{status: false, error:{code: 102, message: "Error updating user"}} . mysqli_error($induction)';
    }
} else {
    echo '{status: false, error:{code: 103, message: "Invalid request"}}';
}
?>
