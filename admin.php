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
            <div class="message error">
                Post successfully deleted.
            </div>
        ';
    }

    if (isset($_GET['created'])) {
        $message = '
            <div class="message success">
                Post successfully created.
            </div>
        ';
    }

    if (isset($_GET['updated'])) {
        $message = '
            <div class="message success">
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

<h1>Admin</h1>
<a href="home.php">Home</a>
<br>

<a href="createPost.php">Make a new post</a>

<?=$message?>

<table id="posts-tbl">
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($posts as $post) { ?>
            <tr>
                <td><?= htmlentities($post->title) ?></td>
                <td><?= htmlentities($post->content) ?></td>
                <td><?= htmlentities($post->author) ?></td>
                <td><?= substr($post->published_date, 0, 10) ?></td>

                <td>
                    <!-- Edit -->
                    <form action="edit.php" method="POST">
                        <input type="hidden" name="ID" value="<?= htmlentities($post->id) ?>">
                        <button>Edit</button>
                    </form>

                    <!-- Delete -->
                    <form action="" method="POST" id="deleteBtn">
                        <input type="hidden" name="ID" value="<?= htmlentities($post->id) ?>">
                        <input type="submit" name="deletePostBtn" value="Delete">
                    </form>
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>

<?php include('layouts/footer.php') ?>