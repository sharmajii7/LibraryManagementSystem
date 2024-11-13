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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Student Register</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="border p-4 shadow rounded">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" name="name" class="form-control" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number:</label>
                        <input type="text" name="pnum" maxlength="10" class="form-control" required/>    
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="password" name="pass" class="form-control" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password:</label>
                        <input type="password" name="confpass" class="form-control" required/>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
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
        
        $uniqueemail = mysqli_query($conn, "SELECT * FROM students WHERE email = '$email';");
        if(mysqli_num_rows($uniqueemail) > 0) {
            echo "<script> alert('Email is already registered.'); </script>";
        } elseif($pass != $confpass) {
            echo "<script> alert('Password and Confirm Password fields do not match.'); </script>";
        } else {
            $stuids = mysqli_query($conn, "SELECT studentID FROM students ORDER BY studentID DESC LIMIT 1;");
            $stuid = "STU100";
            if(mysqli_num_rows($stuids) > 0) {
                $id = mysqli_fetch_assoc($stuids);
                $stuid = ++$id['studentID'];
            }
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            try {
                mysqli_query($conn, "INSERT INTO students (studentID, name, email, phoneNumber, password, status) VALUES ('$stuid', '$name', '$email', '$pnum', '$hash', 1);");
                $_SESSION['message'] = "Successfully Registered.";
                header("Location: index.php");
                exit();
            } catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
        }
    }
    mysqli_close($conn);
?>
