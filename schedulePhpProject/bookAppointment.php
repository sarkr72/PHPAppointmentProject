<?php
session_cache_limiter('nocache');
session_start();
include('db.php');
include('functions.php');

$business_description = '';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch the list of available businesses
$businesses = getBusinesses();

if (isset($_POST['book_appointment'])) {
    $business_description = isset($_POST['business_description']) ? $_POST['business_description'] : '';
    $appointment_time = isset($_POST['appointment_time']) ? $_POST['appointment_time'] : '';

    $app = getAppointment($email);
    if (!$app) {
        $result = create_appointment($email, $business_description, $appointment_time);
        if ($result) {
            $_SESSION['success_message'] = "Appointment booked successfully!";
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $error_message = "You already have an existing appointment.";
        $_SESSION['error_message'] = $error_message;
        header("Location: " . $_SERVER['REQUEST_URI']); // Redirect back to the same page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-6">Book Appointment</h1>

        <?php if (isset($_SESSION['error_message'])) : ?>
            <p id="appointmentInfo" style="color: red;"><?php echo $_SESSION['error_message']; ?></p>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form action="" method="post" class="max-w-md mx-auto">
            <label for="business_description" class="block text-sm font-medium text-gray-700">Business Description</label>
            <select id="business_description" name="business_description" required class="mt-1 p-2 border rounded w-full">
                <option value="">Select a business description</option>
                <?php foreach ($businesses as $business) : ?>
                    <option value="<?= $business['business_description'] ?>" <?= ($business_description === $business['business_description']) ? 'selected' : '' ?>>
                        <?= $business['business_description'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="appointment_time" class="block mt-4 text-sm font-medium text-gray-700">Appointment
                Time</label>
            <input type="datetime-local" id="appointment_time" name="appointment_time" required class="mt-1 p-2 border rounded w-full">

            <button type="submit" name="book_appointment" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Book
                Appointment</button>
        </form>



    </div>

    <script>
        window.onload = function() {
            const appointmentInfoDiv = document.getElementById('appointmentInfo');

            if (appointmentInfoDiv) {
                setTimeout(() => {
                    appointmentInfoDiv.remove();
                }, 4000);
            }
        };
    </script>
</body>

</html>