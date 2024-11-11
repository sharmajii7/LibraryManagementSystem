<?php 
    session_start();
    if(isset($_SESSION["alogin"]) == 0) header("Location: ../adminLogin.php");
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
    <h2> Change Password </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label> Current Password: </label>
    <input type="password" name="currpass" required />
    <label> New Password: </label>
    <input type="password" name="pass" required />
    <label> Confirm Password: </label>
    <input type="password" name="confpass" required />
    <input type="submit" name="change" value="Change Password"/>
</body>
</html>
<?php
    include("components/database.php");
    if(isset($_POST["change"])) {
        $username = $_SESSION["alogin"];
        $currpass = $_POST["currpass"];
        $pass = $_POST["pass"];
        $confpass = $_POST["confpass"];
        $records = mysqli_query($conn, "SELECT * FROM admin where username = '$username';");
        $oldpass = NULL;
        foreach($records as $record) {
            $oldpass = $record["password"];
            break;
        }
        if(password_verify($currpass, $oldpass) == 0) {
            echo "<script> alert('Current Password is incorrect.'); </script>";
        }
        else if($pass != $confpass) {
            echo "<script> alert('Password and Confirm Password fields do not match.'); </script>";
        }
        else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            try {
                mysqli_query($conn, "UPDATE admin SET password='$hash' WHERE username = '$username';");
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
            $_SESSION['message'] = "<script> alert('Password updated successfully.'); </script>";
            header("Location: dashboard.php");
        }
    }
    mysqli_close($conn);
?>