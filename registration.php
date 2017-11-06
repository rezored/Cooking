<?php
include "includes/db.php";
include "includes/header.php";
if (isset($_POST['submit'])) {
    $register_username = $_POST['username'];
    $register_user_email = $_POST['email'];
    $register_user_password = $_POST['password'];
    if (!empty($register_username) && !empty($register_user_email) && !empty($register_user_password)) {
        $register_username = mysqli_real_escape_string($connection, $register_username);
        $register_user_email = mysqli_real_escape_string($connection, $register_user_email);
        $register_user_password = mysqli_real_escape_string($connection, $register_user_password);
        $query = "SELECT randSalt FROM users ";
        $select_randsalt_query = mysqli_query($connection, $query);
        if (!$select_randsalt_query) {
            die("Query failed" . mysqli_error($connection));
        }
        $row = mysqli_fetch_array($select_randsalt_query);
        $salt = $row['randSalt'];
        $crypt_user_password = crypt($register_user_password, $salt);
        $query = "INSERT INTO users (username, user_email, user_password, user_role) "
                . "VALUES ('{$register_username}', '{$register_user_email}', '{$crypt_user_password}', 'subscriber') ";
        $register_user_query = mysqli_query($connection, $query);
        if (!$register_user_query) {
            die("Query failed" . mysqli_error($connection));
        }
        $message1 = "Your registration has beed submited";
        $message2 = "Your registration has beed submited";
        $message3 = "Your registration has beed submited";
    } else {
        $message1 = "Fields cannot be empty";
        $message2 = "Fields cannot be empty";
        $message3 = "Fields cannot be empty";
    }
} else {
    $message1='Enter Username';
    $message2='somebody@example.com';
    $message3='Enter Password';
}


include "includes/navigation.php";
?>
<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo $message1; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo $message2; ?>">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo $message3; ?>">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <hr>
    <?php include "includes/footer.php"; ?>
