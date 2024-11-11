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
    <h2> Student Register </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <label> Name: </label>
        <input type="text" name="name" required/>
        <label> Phone Number: </label>
        <input type="text" name="pnum" maxlength="10" required/>    
        <label> Email: </label>
        <input type="text" name="email" required/>
        <label> Password: </label>
        <input type="password" name="pass" required/>
        <label> Confirm Password: </label>
        <input type="password" name="confpass" required/>
        <input type="submit" name="register" value="Register"/>
    </form>
</body>
</html>
<?php 
    include("components/database.php");
    if(isset($_POST["register"])) {
        $name = $_POST["name"];
        $pnum = $_POST["pnum"];
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $confpass = $_POST["confpass"];
        $uniqueemail = mysqli_query($conn, "SELECT * FROM students where email = '$email';");
        if(mysqli_num_rows($uniqueemail) > 0) {
            echo "<script> alert('Email is already registered.') </script>";
        }
        else if($pass != $confpass) {
            echo "<script> alert('Password and Confirm Password fields do not match.'); </script>";
        }
        else {
            $stuids = mysqli_query($conn, "SELECT studentID FROM students ORDER BY studentID DESC;");
            $stuid = "STU100";
            if(mysqli_num_rows($stuids) > 0) {
                foreach($stuids as $id) {
                    $stuid = $id['studentID'];
                    break;
                }
                $stuid++;
            }
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            try {
                mysqli_query($conn, "INSERT INTO students (studentID, name, email, phoneNumber, password, status) VALUES ('$stuid', '$name', '$email', '$pnum', '$hash', 1);");
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
            $_SESSION['message'] = "<script> alert('Successfully Registered.'); </script>";
            header("Location: index.php");
        }
    }
    mysqli_close($conn);
?>