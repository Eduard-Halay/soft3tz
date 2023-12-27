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
            'status' => true,
            'error' => null,
            'user' => array(
                'id' => $newUserData['id'],
                'name_first' => $newUserData['name'],
                'name_last' => $newUserData['lastname'],
                'status' => $newUserData['status'],
                'role' => $newUserData['role']
            )
        );
    } else {
        $response = array(
            'status' => false,
            'error' => array('code' => 201, 'message' => 'Error inserting user data')
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
