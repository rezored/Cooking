<?php

function insert_categories() {
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "This field shoult not be empty";
        } else {
            $createCat = Database::instance()->prepare("INSERT INTO categories (cat_title) VALUE (:cat_title) ");
            $createCat->bindParam("cat_title", $cat_title);
            $createCat->execute();
        }
    }
}

function findAllCategories() {
    $allCat = Database::instance()->prepare("SELECT * FROM categories ");
    $allCat->execute();
    foreach ($allCat as $row) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories() {
    if (isset($_GET['delete'])) {
        $delete_cat_id = $_GET['delete'];
        $deleteCat = Database::instance()->prepare("DELETE FROM categories WHERE cat_id = :cat_id ");
        $deleteCat->bindParam("cat_id", $delete_cat_id);
        $deleteCat->execute();
        header("Location: categories.php");
    }
}