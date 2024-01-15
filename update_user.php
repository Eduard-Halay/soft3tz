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

            if ($userData === null) {
               
                $errorResponse = array(
                    'status' => false,
                    'error' => array('code' => 104, 'message' => 'object with this ID was not found'),
                    'user' => null
                );
                header('Content-Type: application/json');
                echo json_encode($errorResponse);
                exit;
            }

            $response = array(
                'status' => true,
                'error' => null,
                'user' => array(
                    'id' => $userId,
                    'name_first' => $userData['name'],
                    'name_last' => $userData['lastname'],
                    'status' => $userData['status'],
                    'role' => $userData['role']
                )
            );

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $errorResponse = array(
                'status' => false,
                'error' => array('code' => 101, 'message' => 'Error selecting user'),
                'user' => null
            );
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
        }
    } else {
        $errorResponse = array(
            'status' => false,
            'error' => array('code' => 102, 'message' => 'Error updating user'),
            'user' => null
        );
        header('Content-Type: application/json');
        echo json_encode($errorResponse);
    }
} else {
    $errorResponse = array(
        'status' => false,
        'error' => array('code' => 103, 'message' => 'Invalid request'),
        'user' => null
    );
    header('Content-Type: application/json');
    echo json_encode($errorResponse);
}
?>
