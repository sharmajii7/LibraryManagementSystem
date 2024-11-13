<?php 
session_start();
if(isset($_SESSION["alogin"])) header("Location: admin/dashboard.php");
if(!isset($_SESSION["login"])) header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    <div class="container mt-5">
        <h2 class="text-center">Change Password</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="w-50 mx-auto">
            <div class="mb-3">
                <label for="currpass" class="form-label">Current Password:</label>
                <input type="password" id="currpass" name="currpass" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">New Password:</label>
                <input type="password" id="pass" name="pass" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="confpass" class="form-label">Confirm Password:</label>
                <input type="password" id="confpass" name="confpass" class="form-control" required />
            </div>
            <button type="submit" name="change" class="btn btn-primary w-100">Change Password</button>
        </form>
    </div>
</body>
</html>
<?php
include("components/database.php");
if(isset($_POST["change"])) {
    $email = $_SESSION["login"];
    $currpass = $_POST["currpass"];
    $pass = $_POST["pass"];
    $confpass = $_POST["confpass"];
    $records = mysqli_query($conn, "SELECT password FROM students WHERE email = '$email';");
    $oldpass = mysqli_fetch_assoc($records)["password"] ?? null;
    if(!$oldpass || !password_verify($currpass, $oldpass)) {
        echo "<script>alert('Current Password is incorrect.');</script>";
    } else if($pass != $confpass) {
        echo "<script>alert('Password and Confirm Password fields do not match.');</script>";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        try {
            mysqli_query($conn, "UPDATE students SET password = '$hash' WHERE email = '$email';");
        } catch (mysqli_sql_exception) {
            echo "<script>alert('Database error. Please try again later.');</script>";
        }
        $_SESSION['message'] = "<script>alert('Password updated successfully.');</script>";
        header("Location: dashboard.php");
    }
}
mysqli_close($conn);
?>
