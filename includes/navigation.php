<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">HOME</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <?php if (!isset($_SESSION['user_role'])): ?>
                    <li>
                        <a href="registration.php">Register new account</a>
                    </li>   
                <?php endif; ?>
                <?php
                $rowsComments = Database::instance()->fetchAssoc("SELECT * FROM categories");
                foreach ($rowsComments as $comment):
                    ?>
                    <li>
                        <a href="category.php?category=<?php echo $comment['cat_id']; ?>"><?php echo $comment['cat_title']; ?></a>
                    </li>
                <?php endforeach; ?>

                <?php if (isset($_SESSION['user_role'])): 
                    $user_role = $_SESSION['user_role'];?>
                    <?php if ($user_role === 'admin'): ?>
                        <?php if (isset($_GET['p_id'])): 
                            $edit_post_id = $_GET['p_id']; ?>
                            <li>
                                <a href="../admin/posts.php?source=edit_post&p_id=<?php echo $edit_post_id ?>">Edit post</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (isset($_SESSION['user_role'])):
                    $user_role = $_SESSION['user_role'];
                    if ($user_role === 'admin'):
                        ?>
                        <li style="text-align: right; float: right;">
                            <a href='admin/index.php'>Logged as <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>