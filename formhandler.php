<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
<<<<<<< HEAD

require 'vendor/autoload.php';

=======
require 'vendor/autoload.php';



>>>>>>> 0b1b470 (second cmmit)
// Database Connection
$servername = "localhost";
$username = "u590136986_IWtwp";
$password = "Teksavy2025@";
$dbname = "u590136986_n9hzc";
$port = 3307;

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to send email via PHPMailer
function sendEmailNotification($toEmail, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Hostinger SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'teksavyguys@gmail.com'; // Your Hostinger email address
        $mail->Password = 'bcccsfmxblbfiypj'; // Your Hostinger email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Details
        $mail->setFrom('teksavyguys@gmail.com', 'Teksavy Agency');
        $mail->addAddress($toEmail); // Recipient
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $message;

        $mail->send();
        echo 'Notification email has been sent';
    } catch (Exception $e) {
        echo "Notification email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $service = $conn->real_escape_string($_POST['service']);
    $date = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO teksavy (name, email, phone, service, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $service, $date);

    if ($stmt->execute()) {
        echo "New record created successfully";
        $adminEmail = "teksavyguys@gmail.com"; // Replace with your email address
        $subject = "New Data Inserted";
        $message = "A new record has been inserted into the database.<br><br>
                    <b>Name:</b> $name<br>
                    <b>Email:</b> $email<br>
                    <b>Phone:</b> $phone<br>
                    <b>Service:</b> $service<br>
                    <b>Date:</b> $date";
        sendEmailNotification($adminEmail, $subject, $message);
    } else {
        echo "Error: " . $stmt->error;
    }


    $stmt->close();
}

$conn->close();
?>

