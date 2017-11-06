<?php 

require_once 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $user_password = $_POST['password'];
    $loginUser = Database::instance()->fetchAssoc("SELECT * FROM users WHERE username=:username ", [
        "username"=>$username,
    ]);

    foreach ($loginUser as $row) {
        $login_user_id = $row['user_id'];
        $login_username = $row['username'];
        $login_password = $row['user_password'];
        $login_role = $row['user_role'];
        $login_firstname = $row['user_firstname'];
        $login_lastname = $row['user_lastname'];
        $login_email = $row['user_email'];
    }

    $user_password = crypt($user_password, $login_password);

    if ($username === $login_username && $user_password === $login_password) {
        $_SESSION['user_id'] = $login_user_id;
        $_SESSION['username'] = $login_username;
        $_SESSION['firstname'] = $login_firstname;
        $_SESSION['lastname'] = $login_lastname;
        $_SESSION['user_role'] = $login_role;
        $_SESSION['user_email'] = $login_email;
        header("Location:../admin/index.php");
    } else {
        header("Location:../index.php");
    }
}