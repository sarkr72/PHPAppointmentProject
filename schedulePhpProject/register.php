<?php
session_start();
include('db.php');
include('functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Check if the username already exists
    $existing_email = getEmail($email);
    if ($existing_email) {
        $error = "Username already exists. Choose a different username.";
    } else {
        $result = create_user($name, $email, $password);

        if ($result) {
            $_SESSION['message'] = "Registration successful. You can now log in.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Include the Tailwind CSS styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-300 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded shadow-md w-96 flex flex-col items-center">

        <h2 class=" text-2xl mb-4">Register</h2>

        <?php if (isset($error)) { ?>
            <p class="text-red-500"><?php echo $error; ?></p>
        <?php } ?>

        <form action="register.php" method="post">
            <label for="name" class="block text-sm font-medium text-gray-600">Name:</label>
            <input type="text" id="name" name="name" placeholder="Name" required class="mt-1 p-2 w-full border rounded-md hover:border-blue-500 focus:ring-1">

            <label for="email" class="block text-sm font-medium text-gray-600 mt-4">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required class="mt-1 p-2 w-full border rounded-md hover:border-blue-500 focus:ring-1">

            <label for="password" class="block text-sm font-medium text-gray-600 mt-4">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required class="mt-1 p-2 w-full border rounded-md hover:border-blue-500 focus:ring-1">

            <button type="submit" style="margin-left: 115px;" class="hover:bg-blue-800 mt-4 ml-20 bg-blue-500 text-white p-2 rounded-md">Register</button>
        </form>

        <p class="mt-4 text-gray-600">Already have an account? <a href="index.php" class="hover:text-blue-800 text-blue-500">Login here</a></p>
    </div>

</body>

</html>