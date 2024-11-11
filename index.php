<?php 
    session_start();
    if(isset($_SESSION["alogin"])) header("Location: admin/dashboard.php");
    if(isset($_SESSION["login"])) header("Location: dashboard.php");
    if(!empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Library Management System </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    <h2> Student Login </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <label> Email: </label>
        <input type="text" name="email" required/>
        <label> Password: </label>
        <input type="password" name="pass" required/>
        <input type="submit" name="login" value="Login"/>
    </form>
    <a href="forgotPass.php"> Forgot Password </a> <br>
    <a href="register.php"> Not Registered </a>
</body>
</html>
<?php 
    include("components/database.php");
    if(isset($_POST["login"])) {
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $records = mysqli_query($conn, "SELECT * FROM students WHERE email = '$email';");
        if(mysqli_num_rows($records) > 0) {
            foreach($records as $record) {
                if(password_verify($pass, $record["password"])) {
                    if($record["status"] == 1) {
                        $_SESSION["login"] = $_POST["email"];
                        header("Location: dashboard.php");
                    }
                    else {
                        echo "<script> alert('You have been blocked. Please contact admin.'); </script>";
                    }
                }
                else {
                    echo "<script> alert('Incorrect password.'); </script>";
                }
                break;
            }
        }
        else {
            echo "<script> alert('Email not registered.'); </script>";
        }
    }
    mysqli_close($conn);
?>