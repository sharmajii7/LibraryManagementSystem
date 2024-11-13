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
    <style>
        body {
            background-image: url('path/to/your/library-image.jpg'); /* Replace with the path to your image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .overlay {
            background-color: rgba(255, 255, 255, 0.85); /* Light overlay for readability */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <?php include("components/header.php"); ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="overlay">
                    <h2 class="text-center mb-4">Profile</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label"><strong>Student ID:</strong></label>
                            <p><?php 
                                include("components/database.php");
                                $email = $_SESSION["login"];
                                $records = mysqli_query($conn, "SELECT * FROM students WHERE students.email = '$email';");
                                $stuID = NULL;
                                $regDate = NULL;
                                $status = NULL;
                                $name = NULL;
                                $pnum = NULL;
                                foreach($records as $record) {
                                    $stuID = $record["studentID"];
                                    $regDate = $record["regDate"];
                                    $status = $record["status"];
                                    $name = $record["name"];
                                    $pnum = $record["phoneNumber"];
                                }
                                echo $stuID;
                            ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Registration Date:</strong></label>
                            <p><?php echo $regDate; ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Profile Status:</strong></label>
                            <p><?php echo $status == 1 ? "Active" : "Blocked"; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Full Name:</strong></label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="pnum" class="form-label"><strong>Phone Number:</strong></label>
                            <input type="text" id="pnum" name="pnum" class="form-control" value="<?php echo $pnum; ?>" maxlength="10" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Email:</strong></label>
                            <p><?php echo $email; ?></p>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    if(isset($_POST["update"])) {
        $name = $_POST["name"];
        $pnum = $_POST["pnum"];
        $email = $_SESSION["login"];
        try {
            mysqli_query($conn, "UPDATE students SET name = '$name', phoneNumber = '$pnum' WHERE email = '$email';");
        }
        catch (mysqli_sql_exception) {
            echo "<script> alert('Database error. Please try again later.'); </script>";
        }
        $_SESSION['message'] = "<script> alert('Profile updated successfully.'); </script>";
        header("Location: dashboard.php");
    }
    mysqli_close($conn);
?>
