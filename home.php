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

<h1>Home</h1>
<a href="admin.php">Admin</a>

<?php foreach ($posts as $post) { ?>
    <h2><?= htmlentities($post->title) ?></h2>
    <p><?= substr(htmlentities($post->content), 0, 100) ?></p>
    <i>Author: <?= htmlentities($post->author) ?></i><br>
    <i><?= substr($post->published_date, 0, 10) ?></i>
    <a href="post.php?post=<?=$post->id?>">Go to post</a><br>
<?php }?>

<?php include('layouts/footer.php') ?>