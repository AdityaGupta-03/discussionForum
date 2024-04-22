<?php
$servername = "localhost";      // MySQL server address
$username = "root";             // MySQL username
$password = "";                 // MySQL password
$dbname = "dbforums";           // Name of the database you want to create

// Create Mysql connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$result = $conn->query($sql);

if (!$result) {
    echo "Creating Database Error: " . $conn->error . "<br>";
}

// Connect to the database without closing the connection
$conn->select_db($dbname);

// Creating 1st table
$catTable = 'CATEGORIES';
$sql = "CREATE TABLE IF NOT EXISTS $catTable (
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(50) NOT NULL,
        category_description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";


// even if the table already exists query gets executed and $createTable will contain true;
$createTable = $conn->query($sql);

if (!$createTable) {
    echo "Error creating table: " . $conn->error;
}

// Creating 2nd Table for users login
$userTable = 'USERS';
$sql = "CREATE TABLE IF NOT EXISTS $userTable (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        username VARCHAR(50) NOT NULL,
        password_hash TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";


// even if the table already exists query gets executed and $createTable will contain true;
$createTable = $conn->query($sql);

if (!$createTable) {
    echo "Error creating table: " . $conn->error;
}

// Creating 3rd Table for threads
$threadTable = 'Threads';
$sql = "CREATE TABLE IF NOT EXISTS $threadTable (
        thread_id INT AUTO_INCREMENT PRIMARY KEY,
        thread_title VARCHAR(100) NOT NULL,
        thread_description TEXT,
        thread_userid INT NOT NULL,
        thread_catid INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (thread_userid) REFERENCES USERS(user_id),
        FOREIGN KEY (thread_catid) REFERENCES CATEGORIES(category_id)
    );";

// if attributes are changed and table name remains same then also table won't be created and throws error.
$createTable = $conn->query($sql);

if (!$createTable) {
    echo "Error creating table: " . $conn->error;
}

// Creating 4th Table for comments
$commentTable = 'comments';
$sql = "CREATE TABLE IF NOT EXISTS $commentTable (
        comment_id INT AUTO_INCREMENT PRIMARY KEY,
        comment TEXT NOT NULL,
        thread_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        comment_by INT NOT NULL,
        FOREIGN KEY (thread_id) REFERENCES threads(thread_id),
        FOREIGN KEY (comment_by) REFERENCES users(user_id)
    );";

// if attributes are changed and table name remains same then also table won't be created and throws error.
$createTable = $conn->query($sql);

if (!$createTable) {
    echo "Error creating table: " . $conn->error;
}

?>