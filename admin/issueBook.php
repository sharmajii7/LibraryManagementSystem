<?php 
session_start();
if(isset($_SESSION["alogin"]) == 0) {
    header("Location: ../adminLogin.php");
} else {
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
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Database error. Please try again later.');</script>";
        }
        $_SESSION['message'] = "<script>alert('Book issued successfully.');</script>";
        header("Location: manageIssueBook.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Issue Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include("components/header.php"); ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Issue Book</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="p-4 border rounded bg-light shadow">
                    <div class="mb-3">
                        <label for="student" class="form-label">Student</label>
                        <select name="student" id="student" class="form-select" required>
                            <option value="">Select Student</option>
                            <?php
                                $students = mysqli_query($conn, "SELECT * FROM students WHERE status = 1;");
                                while($student = mysqli_fetch_assoc($students)) {
                                    echo "<option value='{$student['studentID']}'>{$student['studentID']}: {$student['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="book" class="form-label">Book</label>
                        <select name="book" id="book" class="form-select" required>
                            <option value="">Select Book</option>
                            <?php
                                $books = mysqli_query($conn, "SELECT * FROM books;");
                                while($book = mysqli_fetch_assoc($books)) {
                                    echo "<option value='{$book['isbn']}'>{$book['isbn']}: {$book['bookName']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="issue" class="btn btn-primary">Issue Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php 
} 
mysqli_close($conn);
?>
