<?php
/**
 * Filename: login_process.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Process login form submission.
 * Date: 2025
 */
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Login'];
    $password = $_POST['password'];
    
    // Database connection
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "Root_Flower";
    
    $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    
    // First check admin table
    $sql_admin = "SELECT * FROM admin WHERE BINARY username = '$username' AND BINARY password = '$password'";
    $result_admin = mysqli_query($conn, $sql_admin);
    
    if (mysqli_num_rows($result_admin) > 0) {
        $row = mysqli_fetch_assoc($result_admin);
        
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['is_admin'] = true;
        
        mysqli_close($conn);
        header("Location: adminview.php");
        exit();
    }
    
    // Check normal user
    $sql_user = "SELECT * FROM user WHERE BINARY username = '$username' AND BINARY password = '$password'";
    $result_user = mysqli_query($conn, $sql_user);
    
    if (mysqli_num_rows($result_user) > 0) {

        $row = mysqli_fetch_assoc($result_user);
        
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['is_admin'] = false;
        
        mysqli_close($conn);
        header("Location: user.php");
        exit();
    }
    
    // Login failed
    mysqli_close($conn);
    $_SESSION['login_error'] = "Wrong Username or Password!";
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
