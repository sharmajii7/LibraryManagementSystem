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
    <h2> Return Book </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <?php 
        include("components/database.php");
        $id = intval($_GET["issueID"]);
        $records = mysqli_query($conn, "SELECT s.name AS studentName, b.bookName AS bookName, b.isbn AS isbn, 
                    i.issueDate AS issueDate, i.returnDate AS returnDate, i.id AS id, i.fine AS fine 
                    FROM issue i, students s, books b 
                    WHERE i.studentID = s.studentID AND i.bookID = b.isbn AND i.id = '$id';");
        foreach($records as $record) {
    ?>
    <label> Student Name: </label>
    <?php echo $record["studentName"]; ?>
    <br>
    <label> Book Name: </label>
    <?php echo $record["bookName"]; ?>
    <br>
    <label> ISBN: </label>
    <?php echo $record["isbn"]; ?>
    <br>
    <label> Issue Date: </label>
    <?php echo $record["issueDate"]; ?>
    <br>
    <label> Fine: </label>
    <input type="text" name="fine" required>
    <?php }  ?>
    <br>
    <input type="submit" name="return" value="Return Book"/>
</body>
</html>
<?php 
    include("components/database.php");
    if(isset($_POST["return"])) {
        $id = intval($_GET["issueID"]);
        $fine = $_POST["fine"];
        try {
            mysqli_query($conn, "UPDATE issue SET fine = '$fine', returnStatus = 0 WHERE id = '$id';");
        }
        catch (mysqli_sql_exception) {
            echo "<script> alert('Database error. Please try again later.'); </script>";
        }
        $_SESSION['message'] = "<script> alert('Book returned successfully.'); </script>";
        header("location: manageIssueBook.php");
    }
    mysqli_close($conn);
?>