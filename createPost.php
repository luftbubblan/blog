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
                <div class="alert alert-danger">
                    Title must not be empty.
                </div>
            ';
            $empty = "empty";

        } if (empty($content)) {
            $message .= '
                <div class="alert alert-danger">
                    Content must not be empty.
                </div>
            ';
            $empty = "empty";

        } if (empty($author)) {
            $message .= '
                <div class="alert alert-danger">
                    Author must not be empty.
                </div>
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

<div class="header createPostHeader">
    <h1>Create Post</h1>
    <a href="admin.php" class="otherPage">Admin</a>
</div>

<?=$message?>

<form action="" method="POST" id="createPostForm">
    <input type="text" name="title" placeholder="Title" value="<?=$_POST['title']?>" class="textfield">
    <textarea name="content" form="createPostForm" placeholder="Content" class="textfield"><?=$_POST['content']?></textarea>
    <input type="text" name="author" placeholder="Author" value="<?=$_POST['author']?>" class="textfield"><br>
    <input type="submit" name="createPostBtn" value="Create post" class="btn btn-success">
</form>
    
<?php include('layouts/footer.php') ?>