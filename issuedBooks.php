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
    <h2> Issued Books </h2>
    <table class = "table">
        <thead>
            <tr>
                <th> # </th>
                <th> Book Name </th>
                <th> ISBN </th>
                <th> Issued Date </th>
                <th> Return Date </th>
                <th> Fine </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                include("components/database.php");
                $email = $_SESSION["login"];
                $records = mysqli_query($conn, "SELECT * FROM issue, students, books WHERE issue.studentID = students.studentID AND issue.bookID = books.isbn AND students.email = '$email';");
                $rownum = 1;
                if(mysqli_num_rows($records) > 0) {
                    foreach($records as $record) {
            ?>
            <tr>
                <td><?php echo $rownum; ?></td>
                <td><?php echo $record["bookName"]; ?></td>
                <td><?php echo $record["bookID"]; ?></td>
                <td><?php echo $record["issueDate"]; ?></td>
                <td>
                    <?php 
                        if($record["returnDate"])
                            echo $record["returnDate"];
                        else
                            echo "Not Returned";
                    ?>
                </td>
                <td><?php echo $record["fine"]; ?></td>
            </tr>
            <?php 
                $rownum++; 
                }}
            ?>
        </tbody>
    </table>
</body>
</html>
<?php 
    mysqli_close($conn);
?>