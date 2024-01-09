<?php
function get_user_by_id($user_id) {
    $conn = get_connection();
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($query);
    return $result->fetch_assoc();
}



// Add more functions as needed
?>
