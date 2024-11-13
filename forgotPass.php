<?php 
session_start();
if(isset($_SESSION["alogin"])) header("Location: admin/dashboard.php");
if(isset($_SESSION["login"])) header("Location: dashboard.php");
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
        <h2 class="text-center">Recover Password</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="w-50 mx-auto">
            <div class="mb-3">
                <label for="pnum" class="form-label">Phone Number:</label>
                <input type="text" id="pnum" name="pnum" class="form-control" maxlength="10" required/>    
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">New Password:</label>
                <input type="password" id="pass" name="pass" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="confpass" class="form-label">Confirm Password:</label>
                <input type="password" id="confpass" name="confpass" class="form-control" required/>
            </div>
            <button type="submit" name="changepass" class="btn btn-primary w-100">Reset Password</button>
        </form>
    </div>
</body>
</html>
<?php 
include("components/database.php");
if(isset($_POST["changepass"])) {
    $pnum = $_POST["pnum"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $confpass = $_POST["confpass"];
    $uniqueemail = mysqli_query($conn, "SELECT * FROM students WHERE email = '$email' AND phoneNumber = '$pnum';");
    if(mysqli_num_rows($uniqueemail) == 0) {
        echo "<script>alert('No student is registered with the given phone number and email.')</script>";
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
        header("Location: index.php");
    }
}
mysqli_close($conn);
?>
