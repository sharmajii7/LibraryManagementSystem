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
    <h2> Manage Issued Books </h2>
    <table class="table">
        <thead>
            <tr>
                <th> # </th>
                <th> Student Name </th>
                <th> Book Name </th>
                <th> ISBN </th>
                <th> Issued Date </th>
                <th> Return Date </th>
                <th> Fine </th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                include("components/database.php");
                $records = mysqli_query($conn, "SELECT s.name AS studentName, b.bookName AS bookName, b.isbn AS isbn, 
                    i.issueDate AS issueDate, i.returnDate AS returnDate, i.id AS id, i.fine AS fine 
                    FROM issue i, students s, books b 
                    WHERE i.studentID = s.studentID AND i.bookID = b.isbn 
                    ORDER BY i.id DESC;");
                $rownum = 1;
                if(mysqli_num_rows($records) > 0) {
                    foreach($records as $record) {
            ?>
            <tr>
                <td><?php echo $rownum; ?></td>
                <td><?php echo $record["studentName"]; ?></td>
                <td><?php echo $record["bookName"]; ?></td>
                <td><?php echo $record["isbn"]; ?></td>
                <td><?php echo $record["issueDate"]; ?></td>
                <td><?php echo (($record["returnDate"] == "") ? "Not Returned Yet" : $record["returnDate"]); ?></td>
                <td><?php echo (($record["fine"]) ? $record["fine"] : "-"); ?></td>
                <td>
                    <?php if($record["returnDate"] == "") { ?>
                    <a href="returnBook.php?issueID=<?php echo $record["id"]?>"><button> Return </button>
                    <?php } ?>
                </td>
            </tr>
            <?php 
                $rownum++; 
                }}
                mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>