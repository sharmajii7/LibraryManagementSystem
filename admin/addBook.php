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
    <h2> Add Book </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label> Book Name: </label>
    <input type="text" name="book" required />
    <label> Category: </label>
    <select name="category" required>
        <option value=""> Select Category </option>
        <?php
            include("components/database.php");
            $categories = mysqli_query($conn, "SELECT * FROM category WHERE status = 1;");
            if(mysqli_num_rows($categories) > 0) {
                foreach($categories as $category) {
                    ?>
                    <option value="<?php echo $category["id"]; ?>"> <?php echo $category["categoryName"]; ?> </option>
                    <?php
                }
            }
        ?>
    </select>
    <label> Author: </label>
    <select name="author" required>
        <option value=""> Select Author </option>
        <?php
            $authors = mysqli_query($conn, "SELECT * FROM authors;");
            if(mysqli_num_rows($authors) > 0) {
                foreach($authors as $author) {
                    ?>
                    <option value="<?php echo $author["id"]; ?>"> <?php echo $author["authorName"]; ?> </option>
                    <?php
                }
            }
        ?>
    </select>
    <label> ISBN: </label>
    <input type="text" name="isbn" required />
    <label> Price: </label>
    <input type="text" name="price" required />
    <input type="submit" name="submit" value="Add"/>
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
        }
        else if(mysqli_num_rows($uniqueisbn) > 0) {
            echo "<script> alert('ISBN is already taken.') </script>";
        }
        else {
            try {
                mysqli_query($conn, "INSERT INTO books (bookName, categoryID, authorID, isbn, bookPrice) VALUES ('$book', '$category', '$author', '$isbn', '$price');");
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
            $_SESSION['message'] = "<script> alert('Book added successfully.'); </script>";
            header("Location: manageBook.php");
        }
    }
    mysqli_close($conn);
?>