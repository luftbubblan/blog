<?php
    $pageTitle="Edit";

    require('dbconnection.php');

    // READ
    $sql = "
        SELECT * 
        FROM posts 
        WHERE id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_POST['ID']);
    $stmt->execute();
    $post = $stmt->fetch();

    // UPDATE
    $message = "";
    $content = "";
    if (isset($_POST['editPostBtn'])) {
        $content = trim($_POST['content']);

        if (empty($content)) {
            $message = '
                <div class="message error">
                    Content must not be empty.
                </div>
            ';

        } else {
            $sql = "
                UPDATE posts
                SET content = :content
                WHERE id = :id
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":content", $_POST['content']);
            $stmt->bindParam(":id", $_POST['ID']);
            $stmt->execute();
            header('Location: admin.php?updated');
            exit;
        }
    }

    include('layout/header.php')
?>

<h1>Edit Post</h1>
<a href="admin.php">Admin</a>

<?=$message?>

<h3><?= htmlentities($post->title) ?></h3>
<textarea name="content" form="editForm"><?= trim($post->content) ?></textarea>
<p>Posted by: <?= htmlentities($post->author) ?></p>
<i><?= substr($post->published_date, 0, 10) ?>. ID: <?= htmlentities($post->id) ?></i>


<form action="" method="POST" id="editForm">
    <input type="hidden" name="ID" value="<?= htmlentities($post->id) ?>">
    <input type="submit" name="editPostBtn" value="Save">
</form>

<?php include('layouts/footer.php') ?>