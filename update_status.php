<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $newStatus = $_POST['newStatus'];

  
    $updateQuery = "UPDATE `client` SET `status`='$newStatus' WHERE `id`='$userId'";
    
   
    if (mysqli_query($induction, $updateQuery)) {
       
        $selectQuery = "SELECT `status` FROM `client` WHERE `id`='$userId'";
        $result = mysqli_query($induction, $selectQuery);
        
      
        if ($result) {
         
            $row = mysqli_fetch_assoc($result);

          
            $status = $row['status'];

         
            if ($row) {
                echo json_encode(['status' => true, 'error' => null, 'id' => $userId, 'dev' => $status]);
            } else {
                echo json_encode(['status' => false, 'error' => ['code' => 100, 'message' => 'not found user']]);
            }
        } else {
          
            http_response_code(500); 
            echo json_encode(['status' => false, 'error' => ['code' => 105, 'message' => 'Failed to update status']]);
        }
    } else {
        
        http_response_code(500);
        echo json_encode(['status' => false, 'error' => ['code' => 105, 'message' => 'Failed to update status']]);
    }
} else {
   
    http_response_code(400);
    echo json_encode(['status' => false, 'error' => ['code' => 105, 'message' => 'Invalid request method']]);
}
?>
