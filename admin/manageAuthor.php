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
    <h2> Manage Authors </h2>
    <table class="table">
        <thead>
            <tr>
                <th> # </th>
                <th> Author Name </th>
                <th> Registration Date </th>
                <th> Updation Date </th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                include("components/database.php");
                $records = mysqli_query($conn, "SELECT * FROM authors;");
                $rownum = 1;
                if(mysqli_num_rows($records) > 0) {
                    foreach($records as $record) {
            ?>
            <tr>
                <td><?php echo $rownum; ?></td>
                <td><?php echo $record["authorName"]; ?></td>
                <td><?php echo $record["registeredDate"]; ?></td>
                <td><?php echo $record["updationDate"]; ?></td>
                <td>
                    <a href="editAuthor.php?authorid=<?php echo $record["id"]?>"><button> Edit </button>
                    <a href="manageAuthor.php?delete=<?php echo $record["id"]?>"><button> Delete </button>
                </td>
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
    if(isset($_GET["delete"])) {
        $authorid = $_GET["delete"];
        try {
            mysqli_query($conn, "DELETE FROM authors WHERE id = '$authorid';");
        }
        catch (mysqli_sql_exception) {
            echo "<script> alert('Database error. Please try again later.'); </script>";
        }
        $_SESSION['message'] = "<script> alert('Author deleted successfully.'); </script>";
        header("location: manageAuthor.php");
    }
?>