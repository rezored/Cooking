<?php
if (isset($_GET['change_role']) && !empty($_GET['change_role'])) {
    $promote_user_id = $_GET['u_id'];
    $newRole = $_GET['change_role'];
    switch ($newRole) {
        case 'admin':
        case 'subscriber':
            $promoteUser = Database::instance()->prepare("UPDATE users SET user_role=:new_role WHERE user_id=:user_id ");
            $promoteUser->bindParam(":user_id", $promote_user_id);
            $promoteUser->bindParam(":new_role", $newRole);
            $promoteUser->execute();
            header("Location: users.php");
            break;
        default:
        header("Location: users.php" . '?isSuccess=false');
    }
}
if (isset($_GET['delete'])) {
    $delete_user_id = $_GET['delete'];
    $deleteUser = Database::instance()->prepare("DELETE users WHERE user_id=:user_id ");
    $deleteUser->bindParam(":user_id", $delete_user_id);
    $deleteUser->execute();
    header("Location: users.php");
}
?>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>User ID</th>
            <th>User avatar</th>
            <th>User name</th>
            <th>First name</th>
            <th>Last name</th>
            <th>User email</th>
            <th>Role</th>
            <th colspan="4">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $selectUser = Database::instance()->fetchAssoc("SELECT * FROM users ");
        foreach ($selectUser as $row) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td><img width='75' align='center' src='./images/$user_image' atl='image'></td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";
            echo "<td><a href='users.php?change_role=admin&u_id={$user_id}'>Admin</a></td>";
            echo "<td><a href='users.php?change_role=subscriber&u_id={$user_id}'>Subscriber</a></td>";
            echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>