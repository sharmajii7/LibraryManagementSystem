<?php 
    session_start();
    if(isset($_SESSION["alogin"]) == 0) header("Location: ../adminLogin.php");
    else {
        include("components/database.php");
        if(!empty($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        if(isset($_GET["activate"])) {
            $id = $_GET["activate"];
            try {
                mysqli_query($conn, "UPDATE students SET status = 1 WHERE id = '$id';");
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
            $_SESSION['message'] = "<script> alert('Student activated successfully.'); </script>";
            header("location: manageStudent.php");
        }
        if(isset($_GET["block"])) {
            $id = $_GET["block"];
            try {
                mysqli_query($conn, "UPDATE students SET status = 0 WHERE id = '$id';");
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
            $_SESSION['message'] = "<script> alert('Student blocked successfully.'); </script>";
            header("location: manageStudent.php");
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
    <div class="container mt-5">
        <h2 class="mb-4"> Registered Students </h2>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th> # </th>
                    <th> Student ID </th>
                    <th> Student Name </th>
                    <th> Email </th>
                    <th> Mobile Number </th>
                    <th> Registration Date </th>
                    <th> Status </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $records = mysqli_query($conn, "SELECT * FROM students;");
                    $rownum = 1;
                    if(mysqli_num_rows($records) > 0) {
                        foreach($records as $record) {
                ?>
                <tr>
                    <td><?php echo $rownum; ?></td>
                    <td><?php echo $record["studentID"]; ?></td>
                    <td><?php echo $record["name"]; ?></td>
                    <td><?php echo $record["email"]; ?></td>
                    <td><?php echo $record["phoneNumber"]; ?></td>
                    <td><?php echo $record["regDate"]; ?></td>
                    <td><?php echo (($record["status"]) ? "Active" : "Blocked"); ?></td>
                    <td>
                        <?php if($record["status"]) { ?>
                            <a href="manageStudent.php?block=<?php echo $record["id"]; ?>"><button class="btn btn-warning"> Block </button></a>
                        <?php } else { ?>
                            <a href="manageStudent.php?activate=<?php echo $record["id"]; ?>"><button class="btn btn-success"> Activate </button></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php 
                    $rownum++; 
                    }}
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php 
        mysqli_close($conn);
    }
?>
