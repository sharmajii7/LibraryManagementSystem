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
    
    <div class="container my-5">
        <h2 class="mb-4">Add Book</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="book" class="form-label">Book Name</label>
                <input type="text" class="form-control" id="book" name="book" required>
                <div class="invalid-feedback">Please enter the book's name.</div>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <?php
                        include("components/database.php");
                        $categories = mysqli_query($conn, "SELECT * FROM category WHERE status = 1;");
                        if(mysqli_num_rows($categories) > 0) {
                            foreach($categories as $category) {
                                echo "<option value='{$category['id']}'>{$category['categoryName']}</option>";
                            }
                        }
                    ?>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <select class="form-select" id="author" name="author" required>
                    <option value="">Select Author</option>
                    <?php
                        $authors = mysqli_query($conn, "SELECT * FROM authors;");
                        if(mysqli_num_rows($authors) > 0) {
                            foreach($authors as $author) {
                                echo "<option value='{$author['id']}'>{$author['authorName']}</option>";
                            }
                        }
                    ?>
                </select>
                <div class="invalid-feedback">Please select an author.</div>
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
                <div class="invalid-feedback">Please enter the ISBN number.</div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" required>
                <div class="invalid-feedback">Please enter the price.</div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</body>
</html>
<?php 
    if(isset($_POST["submit"])) {
        $book = $_POST["book"];
        $category = $_POST["category"];
        $isbn = $_POST["isbn"];
        $author = $_POST["author"];
        $price = $_POST["price"];
        $uniquebook = mysqli_query($conn, "SELECT * FROM books where bookName = '$book';");
        $uniqueisbn = mysqli_query($conn, "SELECT * FROM books where isbn = '$isbn';");
        if(mysqli_num_rows($uniquebook) > 0) {
            echo "<script> alert('Book is already registered.') </script>";
        } else if(mysqli_num_rows($uniqueisbn) > 0) {
            echo "<script> alert('ISBN is already taken.') </script>";
        } else {
            try {
                mysqli_query($conn, "INSERT INTO books (bookName, categoryID, authorID, isbn, bookPrice) VALUES ('$book', '$category', '$author', '$isbn', '$price');");
                $_SESSION['message'] = "<script> alert('Book added successfully.'); </script>";
                header("Location: manageBook.php");
            } catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
        }
    }
    mysqli_close($conn);
?>
