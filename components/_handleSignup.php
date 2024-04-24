<?php
$showAlert=$showMsg=false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("_database.php");
    $name = $_POST['input_name'];
    $email = $_POST['input_email'];
    $username = $_POST['input_username'];
    $password = $_POST['input_password'];

    $sql = "SELECT * FROM $userTable WHERE username = '$username'";
    $exist = $conn->query($sql);

    if (($exist->num_rows) == 0) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $userTable (name, email, username, password_hash) VALUES ('$name', '$email', '$username', '$password_hash')";

        $result = $conn->query($sql);
        $showMsg = $result ? "Your details have been submitted" : "Error at technical end";
        $showAlert = $result;
    } else {
        $showMsg = "Username already exists, Please try another one.";
        $showAlert = false;
    }
}

// To avoid resubmission
$url = dirname(dirname($_SERVER['PHP_SELF']));
header("Location: $url?signup=$showAlert&msg=$showMsg");
exit();

?>