<?php
function get_connection()
{
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "sqldata";

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function execute_query($query)
{
    $conn = get_connection();
    return $conn->query($query);
}

function getEmail($email)
{
    $conn = get_connection();
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    return $result->fetch_assoc();
}

function getAppointment($userEmail)
{
    $conn = get_connection();
    $query = "SELECT * FROM appointments WHERE userEmail = '$userEmail'";
    $result = $conn->query($query);
    return $result->fetch_assoc();
}

function getBusinesses()
{
    $conn = get_connection();
    $query = "SELECT * FROM businesses";
    $result = $conn->query($query);
    $businesses = [];

    while ($row = $result->fetch_assoc()) {
        $businesses[] = $row;
    }

    return $businesses;
}

function create_appointment($userEmail, $appointmentReason, $appointmentTime)
{
    $conn = get_connection();
    $query = "INSERT INTO appointments (userEmail, appointmentReason, appointmentTime) VALUES ('$userEmail', '$appointmentReason', '$appointmentTime')";
    return execute_query($query);
}

function create_user($name, $email, $password)
{
    $conn = get_connection();
    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    return execute_query($query);
}


