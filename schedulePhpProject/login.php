<?php
session_cache_limiter('nocache');
session_start();
include('db.php');
include('functions.php');

if (isset($_POST['login'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $user = getEmail($email);

    if ($user && $password === $user['password']) {
        $_SESSION['email'] = $user['email'];
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = "Invalid email or password";
        header('Location: login.php'); // Redirect to the same page to clear form data from cache
        exit();
    }
}
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Appointment System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="max-w-md w-full p-8 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Login</h2>

        <?php if (isset($error)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?= $error ?></span>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="text" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <button type="submit" name="login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Log In
            </button>
        </form>
    </div>

</body>

</html>