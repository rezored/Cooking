<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Comment ID</th>
            <th>Author</th>
            <th>Email</th>
            <th>Status</th>
            <th>in response to:</th>
            <th>Content</th>
            <th>Date</th>
            <th colspan="4">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $selectCom = Database::instance()->fetchAssoc("SELECT * FROM comments ORDER BY comment_id DESC ");
        foreach ($selectCom as $row) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];
            echo "<tr>";
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";
            $selectPost = Database::instance()->fetchAssoc("SELECT * FROM posts WHERE post_id=:comment_post_id ", [
                "comment_post_id" => $comment_post_id,
            ]);
            foreach ($selectPost as $row) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            }
            echo "<td>{$comment_content}</td>";
            echo "<td>{$comment_date}</td>";
            echo "<td><a href='comments.php?approve&p_id={$comment_id}'>Approve</a></td>";
            echo "<td><a href='comments.php?unapprove&p_id={$comment_id}'>Unapprove</a></td>";
            echo "<td><a href='comments.php?source=edit_comment&p_id={$comment_id}'>Edit</a></td>";
//            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete ?'); \ href='comments.php?delete={$comment_id}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php
if (isset($_GET['approve'])) {
    $approve_comment_id = $_GET['p_id'];
    $approveCom = Database::instance()->prepare("UPDATE comments SET comment_status='approved' WHERE comment_id = :comment_id");
    $approveCom->bindParam("comment_id", $approve_comment_id);
    $approveCom->execute();
    header("Location: comments.php");
}
if (isset($_GET['unapprove'])) {
    $unapprove_comment_id = $_GET['p_id'];
    $unapproveCom = Database::instance()->prepare("UPDATE comments SET comment_status='unapproved' WHERE comment_id = :comment_id ");
    $unapproveCom->bindParam("comment_id", $unapprove_comment_id);
    $unapproveCom->execute();
    header("Location: comments.php");
}
if (isset($_GET['delete'])) {
    $delete_comment_id = $_GET['delete'];
    $deleteCom = Database::instance()->prepare("DELETE FROM comments WHERE comment_id = {$delete_comment_id} ");
    $deleteCom->bindParam("comment_id", $delete_comment_id);
    $deleteCom->execute();
    header("Location: comments.php");
}
