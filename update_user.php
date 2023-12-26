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
                    'statusOperation' => false,
                    'error' => array('code' => 104, 'message' => 'Object is deleted')
                );
                echo json_encode($errorResponse);
                exit;
            }

           
            $response = array(
                'statusOperation' => true,
                'error' => null,
                'id' => $userId,
                'name' => $userData['name'],
                'lastname' => $userData['lastname'],
                'status' => $userData['status'],
                'role' => $userData['role']
            );

         
            header('Content-Type: application/json');

            
            echo json_encode($response);
        } else {
          
            $errorResponse = array(
                'statusOperation' => false,
                'error' => array('code' => 101, 'message' => 'Error selecting user')
            );
            echo json_encode($errorResponse);
        }
    } else {
       
        $errorResponse = array(
            'statusOperation' => false,
            'error' => array('code' => 102, 'message' => 'Error updating user')
        );
        echo json_encode($errorResponse);
    }
} else {
   
    $errorResponse = array(
        'statusOperation' => false,
        'error' => array('code' => 103, 'message' => 'Invalid request')
    );
    echo json_encode($errorResponse);
}
?>
