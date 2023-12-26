<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $query = "INSERT INTO `client` (`name`, `lastname`, `role`, `status`) VALUES ('$name', '$lastname', '$role', '$status')";
    $insertResult = mysqli_query($induction, $query);

    if ($insertResult) {
       
        $newUserId = mysqli_insert_id($induction);
        $result = mysqli_query($induction, "SELECT * FROM `client` WHERE `id` = $newUserId");
        $newUserData = mysqli_fetch_assoc($result);

        
        $response = array(
            'statusOperation' => true,
            'error' => null,
            'id' => $newUserData['id'],
            'name' => $newUserData['name'],
            'lastname' => $newUserData['lastname'],
            'role' => $newUserData['role'],
            'status' => $newUserData['status']
        );
    } else {
      
        $response = array(
            'statusOperation' => false,
            'error' => array('code' => 201, 'message' => 'Error inserting user data')
        );
    }

    
    header('Content-Type: application/json');

   
    echo json_encode($response);
}
?>
