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
    <h2> Manage Books </h2>
    <table class="table">
        <thead>
            <tr>
                <th> # </th>
                <th> Book Name </th>
                <th> Category </th>
                <th> Author </th>
                <th> ISBN </th>
                <th> Price </th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody>
            <?php 
                include("components/database.php");
                $records = mysqli_query($conn, "SELECT books.bookName AS bookName, category.categoryName AS categoryName, 
                    authors.authorName AS authorName, books.isbn AS isbn, books.bookPrice AS bookPrice, books.id AS id 
                    FROM books, category, authors WHERE books.authorID = authors.ID AND books.categoryID = category.ID;");
                $rownum = 1;
                if(mysqli_num_rows($records) > 0) {
                    foreach($records as $record) {
            ?>
            <tr>
                <td><?php echo $rownum; ?></td>
                <td><?php echo $record["bookName"]; ?></td>
                <td><?php echo $record["categoryName"]; ?></td>
                <td><?php echo $record["authorName"]; ?></td>
                <td><?php echo $record["isbn"]; ?></td>
                <td><?php echo $record["bookPrice"]; ?></td>
                <td>
                    <a href="editBook.php?bookid=<?php echo $record["id"]?>"><button> Edit </button>
                    <a href="manageBook.php?delete=<?php echo $record["id"]?>"><button> Delete </button>
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
        $id = $_GET["delete"];
        try {
            mysqli_query($conn, "DELETE FROM books WHERE id = '$id';");
        }
        catch (mysqli_sql_exception) {
            echo "<script> alert('Database error. Please try again later.'); </script>";
        }
        $_SESSION['message'] = "<script> alert('Book deleted successfully.'); </script>";
        header("location: manageBook.php");
    }
    mysqli_close($conn);
?>