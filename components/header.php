<?php if(isset($_SESSION['login'])) { ?>
    <ul>
        <ul>
        <li><a href="dashboard.php"> Dashboard </a></li>
        <li>
            <span> Account </span>
            <ul>
                <li><a href="profile.php"> Profile </a></li>
                <li><a href="changePass.php"> Change Password </a></li>
            </ul>
        </li>
        <li><a href="issuedBooks.php"> Issued Books </a></li>
    </ul>
    <a href="logout.php"> Log out </a>
<?php } else { ?>
    <ul>
        <li><a href="adminLogin.php"> Admin Login </a></li>
        <li><a href="register.php"> Student Register </a></li>
        <li><a href="index.php"> Student Login </a></li>
    </ul>
<?php } ?>