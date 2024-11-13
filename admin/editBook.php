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
    <title>Library Management System - Update Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    <div class="container my-5">
        <h2 class="mb-4">Update Book</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php 
            include("components/database.php");
            $id = intval($_GET["bookid"]);
            $records = mysqli_query($conn, "SELECT books.bookName AS bookName, category.categoryName AS categoryName, 
                authors.authorName AS authorName, authors.id AS authorID, category.id AS categoryID, books.isbn AS isbn,
                books.bookPrice AS bookPrice, books.id AS id FROM books, category, authors 
                WHERE books.authorID = authors.ID AND books.categoryID = category.ID AND books.id = '$id';");
            foreach($records as $record) {
            ?>
            <div class="mb-3">
                <label class="form-label">Book Name:</label>
                <input type="text" name="book" class="form-control" value="<?php echo $record["bookName"]; ?>" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Category:</label>
                <select name="category" class="form-select" required>
                    <option value="<?php echo $record["categoryID"]; ?>"> <?php echo $record["categoryName"]; ?> </option>
                    <?php
                    $categories = mysqli_query($conn, "SELECT * FROM category WHERE status = 1;");
                    if(mysqli_num_rows($categories) > 0) {
                        foreach($categories as $category) {
                            if($category["categoryName"] != $record["categoryName"]) {
                                echo "<option value='{$category["id"]}'>{$category["categoryName"]}</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Author:</label>
                <select name="author" class="form-select" required>
                    <option value="<?php echo $record["authorID"]; ?>"> <?php echo $record["authorName"]; ?> </option>
                    <?php
                    $authors = mysqli_query($conn, "SELECT * FROM authors;");
                    if(mysqli_num_rows($authors) > 0) {
                        foreach($authors as $author) {
                            if($author["authorName"] != $record["authorName"]) {
                                echo "<option value='{$author["id"]}'>{$author["authorName"]}</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">ISBN:</label>
                <input type="text" name="isbn" class="form-control" value="<?php echo $record["isbn"]; ?>" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Price:</label>
                <input type="text" name="price" class="form-control" value="<?php echo $record["bookPrice"]; ?>" required />
            </div>
            <?php } mysqli_close($conn); ?>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>

<?php 
include("components/database.php");
if(isset($_POST["update"])) {
    $id = intval($_GET["bookid"]);
    $book = $_POST["book"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $isbn = $_POST["isbn"];
    $price = $_POST["price"];
    
    $uniquebook = mysqli_query($conn, "SELECT * FROM books WHERE bookName = '$book' AND id <> '$id';");
    $uniqueisbn = mysqli_query($conn, "SELECT * FROM books WHERE isbn = '$isbn' AND id <> '$id';");
    
    if(mysqli_num_rows($uniquebook) > 0) {
        echo "<script> alert('Book is already registered.') </script>";
    }
    else if(mysqli_num_rows($uniqueisbn) > 0) {
        echo "<script> alert('ISBN is already taken.') </script>";
    }
    else {
        try {
            mysqli_query($conn, "UPDATE books SET bookName = '$book', categoryID = '$category',
                authorID = '$author', isbn = '$isbn', bookPrice = '$price' WHERE id = '$id';");
            $_SESSION['message'] = "<script> alert('Book updated successfully.'); </script>";
            header("location: manageBook.php");
        }
        catch (mysqli_sql_exception $e) {
            echo "<script> alert('Database error. Please try again later.'); </script>";
        }
    }
}
mysqli_close($conn);
?>
