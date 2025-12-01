<?php
/**
 * Filename: edit_promotion.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to edit an existing promotion.
 * Date: 2025
 */
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Root_Flower";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request: Missing or invalid ID");
}

$id = (int)$_GET['id'];
$promotion = null;
$message = '';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$stmt = $conn->prepare("SELECT * FROM promotions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$promotion = $result->fetch_assoc();
$stmt->close();

if (!$promotion) {
    die("Promotion not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $imagePath = $promotion['image'];
    $uploadError = "";

    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "IMAGE/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadError = "File is not an image.";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 5000000) {
            $uploadError = "Sorry, your file is too large (max 5MB).";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $uploadError = "Sorry only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $imagePath = $target_file;
            } else {
                $uploadError = "Sorry, there was an error uploading your file.";
            }
        }
    }

    if (empty($uploadError)) {
        $stmt = $conn->prepare("UPDATE promotions SET title = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $description, $imagePath, $id);

        if ($stmt->execute()) {
            $message = "Promotion updated successfully!";
            
            $stmt_refresh = $conn->prepare("SELECT * FROM promotions WHERE id = ?");
            $stmt_refresh->bind_param("i", $id);
            $stmt_refresh->execute();
            $result_refresh = $stmt_refresh->get_result();
            $promotion = $result_refresh->fetch_assoc();
            $stmt_refresh->close();
        } else {
            $message = "Error updating promotion: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = $uploadError;
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Root Flower is a flower shop that based on Kuching, Sarawak Malaysia">
    <meta name="keywords" content="Flower, Root Flower, Kuching, Sarawak, Malaysia">
    <meta name="author" content="Kevinn Jose, Jiang Yu, Vincent, Ahmed">
    <title>Edit Promotion - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="view-edit-container">
        <?php if ($promotion): ?>
            <h1 class="page-title">Edit Promotion</h1>

            <?php if ($message): ?>
                <div class="message-box <?php echo strpos($message, 'successfully') !== false ? 'message-success' : 'message-error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="content-card">
                <form method="POST" class="edit-form" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Promotion Details</legend>
                        
                        <label for="title">Title *</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($promotion['title']); ?>" required>

                        <label for="image">Image (Leave blank to keep current)</label>
                        <input type="file" id="image" name="image">
                        <p>Current Image:</p>
                        <img src="<?php echo htmlspecialchars($promotion['image']); ?>" alt="Current" class="promo-preview">

                        <label for="description">Description *</label>
                        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($promotion['description']); ?></textarea>
                    </fieldset>

                    <div class="editform-actions">
                        <button type="submit" class="editbtn editbtn-save">Update Promotion</button>
                        <a href="adminview.php?page=promotion" class="editbtn editbtn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="content-card">
                Promotion not found.
            </div>
            <div class="form-actions">
                <a href="adminview.php?page=promotion" class="editbtn editbtn-cancel">Back to List</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
