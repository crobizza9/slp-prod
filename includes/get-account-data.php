<?php
include '../includes/db_connect.php';

// -------------------------
// Fetch user data
// -------------------------
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT firstname, lastname, email, profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $email, $profile_pic_filename);
$stmt->fetch();
$stmt->close();


$profile_pic = '/uploads/avatars/' . htmlspecialchars($profile_pic_filename);

$success = $error = "";

// -------------------------
// Handle form submission
// -------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_firstname     = trim($_POST['firstname'] ?? '');
    $new_lastname      = trim($_POST['lastname'] ?? '');
    $new_email         = trim($_POST['email'] ?? '');
    $new_password      = trim($_POST['password'] ?? '');
    $confirm_password  = trim($_POST['confirm_password'] ?? '');
    $new_profile_pic_filename = $profile_pic_filename; // Default to existing filename

    // -------------------------
    // Handle profile picture upload
    // -------------------------
    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/avatars/"; // Absolute path
        $filename = basename($_FILES["profile_pic"]["name"]);
        $target_file = $target_dir . $filename;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $valid_extensions = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $valid_extensions)) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $new_profile_pic_filename = $filename;
            } else {
                $error = "Error uploading profile picture. Check folder permissions.";
            }
        } else {
            $error = "Invalid image format. Allowed: JPG, JPEG, PNG, GIF.";
        }
    }

    // -------------------------
    // Handle password update logic
    // -------------------------
    if (!empty($new_password) || !empty($confirm_password)) {
        if ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } elseif (strlen($new_password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        }
    }

    // -------------------------
    // Update database if no errors
    // -------------------------
    if (empty($error)) {
        $fields = [];
        $params = [];
        $types = "";

        if (!empty($new_firstname)) {
            $fields[] = "firstname = ?";
            $params[] = $new_firstname;
            $types .= "s";
        }
        if (!empty($new_lastname)) {
            $fields[] = "lastname = ?";
            $params[] = $new_lastname;
            $types .= "s";
        }
        if (!empty($new_email)) {
            $fields[] = "email = ?";
            $params[] = $new_email;
            $types .= "s";
        }
        if (!empty($new_password)) {
            $fields[] = "password = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }
        if ($new_profile_pic_filename !== $profile_pic_filename) {
            $fields[] = "profile_pic = ?";
            $params[] = $new_profile_pic_filename;
            $types .= "s";
        }

        if (!empty($fields)) {
            $query = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
            $stmt = $conn->prepare($query);
            $types .= "i";
            $params[] = $user_id;
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                $success = "Account information updated successfully.";
                // Update runtime data
                $firstname = $new_firstname ?: $firstname;
                $lastname = $new_lastname ?: $lastname;
                $email = $new_email ?: $email;
                $profile_pic_filename = $new_profile_pic_filename;
                $profile_pic = '/uploads/avatars/' . htmlspecialchars($profile_pic_filename);
            } else {
                $error = "Error updating account: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $success = "No changes were made.";
        }
    }
}
