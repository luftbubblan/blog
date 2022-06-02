<?php
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    require('dbconnection.php');

    $pageTitle="Admin";

    $message = "";

    // DELETE
    if (isset($_POST['deletePostBtn'])) {
        $sql = "
        DELETE FROM posts
        WHERE id = :id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $_POST['ID']);
        $stmt->execute();
        header('Location: admin.php?deleted');
        exit; 
    }

    if (isset($_GET['deleted'])) {
        $message = '
            <div class="alert alert-warning">
                Post successfully deleted.
            </div>
        ';
    }

    if (isset($_GET['created'])) {
        $message = '
            <div class="alert alert-success">
                Post successfully created.
            </div>
        ';
    }

    if (isset($_GET['updated'])) {
        $message = '
            <div class="alert alert-success">
                Post successfully updated.
            </div>
        ';
    }

    // READ
    $stmt = $pdo->query("
        SELECT * 
        FROM posts 
        ORDER BY id DESC
    ");
    $posts = $stmt->fetchAll();

    include('layout/header.php')
?>

<div class="header">
    <h1>Admin</h1>
    <div class="divInHeader">
        <a href="home.php">Home</a>
        <form action="createPost.php">
            <input type="submit" value="Create new post" class="btn btn-createNewPost">
        </form>
    </div>
</div>
<!-- <a href="createPost.php">Create new post</a> -->

<?=$message?>

<table id="posts-tbl">
    <thead>
        <tr>
            <th>Title</th>
            <th>Content <div class='notbold'>(first 100 characters)</div></th>
            <th>Author</th>
            <th class="dateColumn">Published</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($posts as $post) { ?>
            <tr>
                <td><?= htmlentities($post->title) ?></td>
                <td><?= substr(htmlentities($post->content), 0, 100) ?></td>
                <td><?= htmlentities($post->author) ?></td>
                <td><?= substr($post->published_date, 0, 10) ?></td>

                <td>
                    <!-- Edit -->
                    <form action="edit.php" method="POST">
                        <input type="hidden" name="ID" value="<?= htmlentities($post->id) ?>">
                        <input type="submit" value="Edit" class="btn btn-warning">
                    </form>

                    <!-- Delete -->
                    <form action="" method="POST" id="deleteBtn">
                        <input type="hidden" name="ID" value="<?= htmlentities($post->id) ?>">
                        <input type="submit" name="deletePostBtn" value="Delete" class="btn btn-danger">
                    </form>
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>

<?php include('layouts/footer.php') ?>