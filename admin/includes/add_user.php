<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (isset($_POST['create_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($user_image_temp, "./images/$user_image");
    $createUser = Database::instance()->prepare("INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) "
            . "VALUES (:username,:user_password,:user_firstname,:user_lastname,:user_email,:user_image,:user_role)");
    $createUser->bindParam(":username", $username);
    $createUser->bindParam(":user_password", $user_password);
    $createUser->bindParam(":user_firstname", $user_firstname);
    $createUser->bindParam(":user_lastname", $user_lastname);
    $createUser->bindParam(":user_email", $user_email);
    $createUser->bindParam(":user_image", $user_image);
    $createUser->bindParam(":user_role", $user_role);
    $createUser->execute();
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_image">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <select name="user_role" id="" class="form-control">            
            <option value="subscriber">Select option...</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">User name</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add user">
        <?php
        if (isset($_POST['create_user'])) {
            echo "User Created" . " " . "<a href='users.php'>View users</a>";
        }
        ?>
    </div>
</form>