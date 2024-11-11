<?php 
    session_start();
    if(isset($_SESSION["alogin"]) == 0) header("Location: ../adminLogin.php");
    else {
        include("components/database.php");
        if(!empty($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        if(isset($_POST["issue"])) {
            $stuid = strtoupper($_POST["student"]);
            $bookisbn = $_POST["book"];
            try {
                mysqli_query($conn, "INSERT INTO issue (bookID, studentID) VALUES ('$bookisbn', '$stuid');");
            }
            catch (mysqli_sql_exception) {
                echo "<script> alert('Database error. Please try again later.'); </script>";
            }
            $_SESSION['message'] = "<script> alert('Book issued successfully.'); </script>";
            header("Location: manageIssueBook.php");
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
    <h2> Issue Book </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label> Student: </label>
    <select name="student" required>
        <option value=""> Select Student </option>
        <?php
            $students = mysqli_query($conn, "SELECT * FROM students WHERE status = 1;");
            if(mysqli_num_rows($students) > 0) {
                foreach($students as $student) {
                    ?>
                    <option value="<?php echo $student["studentID"]; ?>"> <?php  echo $student["studentID"] . ": " . $student["name"]; ?> </option>
                    <?php
                }
            }
        ?>
    </select>
    <label> Book: </label>
    <select name="book" required>
        <option value=""> Select Book </option>
        <?php
            $books = mysqli_query($conn, "SELECT * FROM books;");
            if(mysqli_num_rows($books) > 0) {
                foreach($books as $book) {
                    ?>
                    <option value="<?php echo $book["isbn"]; ?>"> <?php echo $book["isbn"] . ": " . $book["bookName"]; ?> </option>
                    <?php
                }
            }
        ?>
    </select>
    <input type="submit" name="issue" value="Issue Book"/>
</body>
</html>
<?php 
    }
    mysqli_close($conn);
?>