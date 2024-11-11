<?php 
    session_start();
    if(isset($_SESSION["alogin"])) header("Location: admin/dashboard.php");
    if(isset($_SESSION["login"]) == 0) header("Location: index.php");
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
    <h2> Profile </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <h4> Student ID: </h4>
    <?php 
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
    ?>
    <h4> Registration Date: </h4>
    <?php echo $regDate; ?>
    <h4> Profile Status: </h4>
    <?php 
        if($status == 1) echo "Active";
        else echo "Blocked";
    ?>
    <h4> Full Name: </h4>
    <input type="text" name="name" value="<?php echo $name; ?>" required />
    <h4> Phone Number: </h4>
    <input type="text" name="pnum" value="<?php echo $pnum; ?>" maxlength="10" required />
    <h4> Email: </h4>
    <?php echo $email . "<br>"; ?>
    <input type="submit" name="update" value="Update"/>
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