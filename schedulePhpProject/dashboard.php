<!-- HTML code for business dashboard -->
<?php
session_start();
include('db.php');
include('functions.php');

if (isset($_POST['view_appointment'])) {
    $email = $_SESSION['email'];
    $appointment = getAppointment($email);
    if ($appointment) {
        $_SESSION['appointment_info'] = $appointment;
    }
    $showAppointmentInfo = true;
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    // Unset the session variable to clear the message
    unset($_SESSION['success_message']);
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['book_appointment'])) {
    header("Location: bookAppointment.php");
    exit();
}

if (isset($_POST['logout'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['cancel_appointment'])) {
    // Handle appointment cancellation logic
}



// Add more functions as needed
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Interface</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-300">
    <div class=" container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-6">Customer Interface</h1>

        <?php if (isset($success_message)) : ?>
            <div class="bg-green-200 text-green-800 p-4 mb-4 rounded">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Book Appointment Form -->
        <div class="mb-8">
            <form action="" method="post">
                <!-- Appointment booking form fields go here -->
                <button type="submit" name="book_appointment" class="w-60 bg-blue-500 text-white px-4 py-2 rounded">Book
                    Appointment</button>
            </form>
        </div>

        <!-- View Appointments -->
        <div class="mb-8">
            <form action="" method="post">
                <!-- Logic to fetch and display user appointments -->
                <button type="submit" name="view_appointment" class="w-60 bg-green-500 text-white px-4 py-2 rounded">View My
                    Appointment</button>
            </form>
        </div>

        <?php if (isset($showAppointmentInfo) && $showAppointmentInfo) : ?>
            <div id="appointmentInfo" class="bg-green-200 text-green-800 p-4 mb-4 rounded">
                Appointment Reason: <?php echo $appointment['appointmentReason']; ?><br>
                Appointment Date: <?php echo $appointment['appointmentTime']; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <!-- Your other form elements -->
            <button type="submit" name="logout" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                Logout
            </button>
        </form>

        <script>
            const appointmentInfoDiv = document.getElementById('appointmentInfo');

            if (appointmentInfoDiv) {
                setTimeout(() => {
                    appointmentInfoDiv.remove();
                }, 5000);
            }
        </script>
    </div>
</body>

</html>