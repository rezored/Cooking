<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (isset($_GET['u_id'])) {
    $edit_user_id = $_GET['u_id'];
    $updateUser = Database::instance()->prepare("SELECT * FROM users WHERE user_id=$edit_user_id");
    $updateUser->execute();
    foreach ($updateUser as $row) {
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_role = $row['user_role'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
    }
}
if (isset($_POST['edit_user'])) {
    $update_user_firstname = $_POST['user_firstname'];
    $update_user_lastname = $_POST['user_lastname'];
    $update_user_role = $_POST['user_role'];
    $update_username = $_POST['username'];
    $update_user_email = $_POST['user_email'];
//    $update_user_password = $_POST['user_password'];
    $update_user_image = $_FILES['image']['name'];
    $update_user_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($update_user_image_temp, "./images/$update_user_image");
    if (empty($update_user_image)) {
        $uploadImage = Database::instance()->fetchAssoc("SELECT * FROM users WHERE user_id = $edit_user_id ");
        foreach ($uploadImage as $row) {
            $update_user_image = $row['user_image'];
        }
    }
    $updateUser = Database::instance()->prepare("UPDATE users SET username=:username, user_firstname=:user_firstname, user_lastname=:user_lastname, "
            . "user_role=:user_role, user_email=:user_email, user_image=:user_image WHERE user_id = :user_id");
    $updateUser->bindParam(":user_id", $edit_user_id);
    $updateUser->bindParam(":username", $update_username);
    $updateUser->bindParam(":user_firstname", $update_user_firstname);
    $updateUser->bindParam(":user_lastname", $update_user_lastname);
    $updateUser->bindParam(":user_role", $update_user_role);
    $updateUser->bindParam(":user_email", $update_user_email);
    $updateUser->bindParam(":user_image", $update_user_image);
    $updateUser->execute();
    header('Location:users.php');
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
    </div>
    <div class="form-group">
        <img width="75" src="./images/<?php echo $user_image; ?>"     
    </div>
    <div class="form-group">
        <label for="user_image">User avatar</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <select name="user_role" id="" class="form-control">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
            if ($user_role == 'admin') {
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="username">User name</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>
    <!--    <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" class="form-control" name="user_password">
        </div>-->
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Edit user">
    </div>
</form>