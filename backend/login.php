<?php
include 'db/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $select = "SELECT * FROM accounts";
    $run = mysqli_query($connect, $select);

    while ($row = mysqli_fetch_array($run)) {
        $email_db = $row['email'];

        if ($email_db == $email) {
            $pass_db = $row['pass'];

            if ($pass_db == $pass) {
                $name_db = $row['name'];
                $type_id = $row['type_id'];
                $acc_id = $row['acc_id'];
                $response = [
                    "message" => "Form submitted successfully",
                    "email" => $email,
                    "name" => $name_db,
                    "type_id" => $type_id,
                    "acc_id" => $acc_id
                ];

                header("Content-Type: application/json");
                echo json_encode($response);
                exit(); // Terminate the script after sending the response
            } else {
                echo "You entered the wrong email/password";
                exit(); // Terminate the script after sending the error message
            }
        }
    }

    // If the email doesn't match any records
    echo "Email not found";
    exit(); // Terminate the script after sending the error message
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method";
    exit(); // Terminate the script after sending the error message
}
?>
