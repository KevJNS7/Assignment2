<?php
/**
 * Filename: create_promotion.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to create a new promotion.
 * Date: 2025
 */
// Redirect if accessed directly
if (basename($_SERVER['PHP_SELF']) == 'create_promotion.php' && !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: adminview.php?page=promotion");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Root_Flower";

$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Error
    $target_dir = "IMAGE/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check is it an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 5000000) {
        $error = "Sorry, your file is too large (max 5MB).";
        $uploadOk = 0;
    }

    // Only certain file
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        if (empty($error)) $error = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $stmt = $conn->prepare("INSERT INTO promotions (image, title, description) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $target_file, $title, $description);

            if ($stmt->execute()) {
                $success = true;
                header("Location: adminview.php?page=promotion");
                exit();
            } else {
                $error = "Error saving promotion: " . $stmt->error;
            }
            $stmt->close();
            mysqli_close($conn);
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Root Flower is a flower shop that based on Kuching, Sarawak Malaysia">
    <meta name="keywords" content="Flower, Root Flower, Kuching, Sarawak, Malaysia">
    <meta name="author" content="Kevinn Jose, Jiang Yu, Vincent, Ahmed">
    <title>Create Promotion - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="admin-page">
        <div class="page-title-row">
            <h1 class="page-title">Create New Promotion</h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="" class="enquiry-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="image">Image *</label>
                <input type="file" id="image" name="image" required>
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submitt-btn">Save Promotion</button>
                <a href="adminview.php?page=promotion" class="cancell-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
