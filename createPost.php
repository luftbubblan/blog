<?php
    require('dbconnection.php');

    $pageTitle="Create Post";
    
    // CREATE
    $message = "";
    $title = "";
    $content = "";
    $author = "";
    $empty = "not empty";
    if (isset($_POST['createPostBtn'])) {
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $author = trim($_POST['author']);

        if (empty($title)) {
            $message .= '
                Title must not be empty.<br>
            ';
            $empty = "empty";

        } if (empty($content)) {
            $message .= '
                Content must not be empty.<br>
            ';
            $empty = "empty";

        } if (empty($author)) {
            $message .= '
                Author must not be empty.
            ';
            $empty = "empty";

        } if ($empty == "not empty") {
            $sql = "
            INSERT INTO posts (title, content, author)
            VALUES (:title, :content, :author)"
            ;
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":content", $content);
            $stmt->bindParam(":author", $author);
            $stmt->execute();
            header('Location: admin.php?created');
            exit;
        }
    }

    include('layout/header.php');
?>

<h1>Create Post</h1>
<a href="admin.php">Admin</a>

<div class="alert error">
    <?=$message?>
</div>


<form action="" method="POST" id="createPostForm">
    <input type="text" name="title" placeholder="Title" value="<?=$_POST['title']?>">
    <textarea name="content" form="createPostForm" placeholder="Content"><?=$_POST['content']?></textarea>
    <input type="text" name="author" placeholder="Author" value="<?=$_POST['author']?>">
    <input type="submit" name="createPostBtn" value="Create post">
</form>
    
<?php include('layouts/footer.php') ?>