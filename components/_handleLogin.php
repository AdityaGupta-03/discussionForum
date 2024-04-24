<?php

$login = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("_database.php");
    $username = $_POST['input_username'];
    $password = $_POST['input_password'];

    $sql = "SELECT * FROM $userTable WHERE username = '$username'";
    $exist = $conn->query($sql);

    if ($exist->num_rows == 1) {
        $row = $exist->fetch_assoc();

        if (password_verify($password, $row['password_hash'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $showMsg  = "You are logged in Successfully";
            $showAlert = true;
        } else {
            $showMsg = "Password didn't match";
            $showAlert = false;
        }
    } else {
        $showMsg = "Invalid Login Credentials";
        $showAlert = false;
    }
}

// To avoid resubmission
$url = dirname(dirname($_SERVER['PHP_SELF']));
header("Location: $url?login=$showAlert&msg=$showMsg");
exit();

?>