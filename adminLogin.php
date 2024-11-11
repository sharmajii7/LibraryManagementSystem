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
    <title> Library Management System </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    <h2> Admin Login </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <label> Username: </label>
        <input type="text" name="uname" required/>
        <label> Password: </label>
        <input type="password" name="pass" required/>
        <input type="submit" name="login" value="Login"/>
    </form>
</body>
</html>
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
                }
                else {
                    echo "<script> alert('Incorrect password.'); </script>";
                }
                break;
            }
        }
        else {
            echo "<script> alert('Incorrect Admin Username.'); </script>";
        }
    }
    mysqli_close($conn);
?>