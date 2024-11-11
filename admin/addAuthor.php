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
    <h2> Add Author </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label> Author Name: </label>
    <input type="text" name="author" required />
    <input type="submit" name="submit" value="Add"/>
</body>
</html>
<?php 
    include("components/database.php");
    if(isset($_POST["submit"])) {
        $author = $_POST["author"];
        $uniqueauthor = mysqli_query($conn, "SELECT * FROM authors where authorName = '$author';");
        if(mysqli_num_rows($uniqueauthor) > 0) {
            echo "<script> alert('Author is already registered.') </script>";
        }
        else {
            try {
                mysqli_query($conn, "INSERT INTO authors (authorName) VALUES ('$author');");
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
            echo "<script> alert('Author added successfully.'); </script>";
        }
    }
    mysqli_close($conn);
?>