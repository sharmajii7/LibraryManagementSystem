<?php 
    session_start();
    if(isset($_SESSION["alogin"])) header("Location: admin/dashboard.php");
    if(isset($_SESSION["login"])) header("Location: dashboard.php");
    if(!empty($_SESSION['message'])) {
        echo '<div class="alert alert-info text-center">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Admin Login</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="border p-4 shadow rounded">
                    <div class="mb-3">
                        <label for="uname" class="form-label"><strong>Username:</strong></label>
                        <input type="text" id="uname" name="uname" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label"><strong>Password:</strong></label>
                        <input type="password" id="pass" name="pass" class="form-control" required />
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <?php 
        include("components/database.php");
        if(isset($_POST["login"])) {
            $uname = $_POST["uname"];
            $pass = $_POST["pass"];
            $records = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$uname';");
            if(mysqli_num_rows($records) > 0) {
                foreach($records as $record) {
                    if(password_verify($pass, $record["password"])) {
                        $_SESSION["alogin"] = $_POST["uname"];
                        header("Location: admin/dashboard.php");
                        exit();
                    } else {
                        echo "<script> alert('Incorrect password.'); </script>";
                    }
                    break;
                }
            } else {
                echo "<script> alert('Incorrect Admin Username.'); </script>";
            }
        }
        mysqli_close($conn);
    ?>
</body>
</html>
