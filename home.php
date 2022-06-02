<?php
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    require('dbconnection.php');

    $pageTitle="Home";

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
    <h1>My Blog</h1>
    <a href="admin.php" class="otherPage">Admin</a>
</div>
<hr>

<?php foreach ($posts as $post) { ?>
    <h3><?= htmlentities($post->title) ?></h3>
    <p><?= substr(htmlentities($post->content), 0, 100) ?></p>
    <i>Author: <?= htmlentities($post->author) ?></i><br>
    <i><?= substr($post->published_date, 0, 10) ?></i>
    <a href="post.php?post=<?=$post->id?>">Show post</a>
    <hr>
<?php }?>

<?php include('layouts/footer.php') ?>