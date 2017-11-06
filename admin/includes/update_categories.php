<form action="" method="post">
    <div class="form-group"><label for="cat-title">Edit category's</label>
        <?php
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];
            $selectCat = Database::instance()->fetchAssoc("SELECT * FROM categories WHERE cat_id = :cat_id", [
                "cat_id" => $cat_id,
            ]);
            foreach ($selectCat as $row) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                ?>
                <input value="<?php
                if (isset($cat_title)) {
                    echo $cat_title;
                }
                ?>" type="text" class="form-control" name="cat_title">
                       <?php
                   }
               }
               if (isset($_POST['update_category'])) {
                   $update_cat_title = $_POST['cat_title'];
                   $updateCat = Database::instance()->prepare("UPDATE categories SET cat_title = :cat_title WHERE cat_id = :cat_id");
                   $updateCat->bindParam(":cat_title", $update_cat_title);
                   $updateCat->bindParam(":cat_id", $cat_id);
                   $updateCat->execute();
                   $operation_massage = "Update was sucessful";
               }
               ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update category"><?php
        if (isset($_POST['update_category'])) {
            echo $operation_massage;
        }
        ?>

    </div> 


</form>