<?php
    require('dbconnection.php');

    $pageTitle="Single Post";

    // READ
    $sql = "
        SELECT * 
        FROM posts 
        WHERE id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_GET['post']);
    $stmt->execute();
    $post = $stmt->fetch();

    include('layout/header.php')
?>

<a href="home.php" class="back">&#8592; Go back</a>
<div class="header"></div>


<h1><?= htmlentities($post->title) ?></h1>
<p><?= htmlentities($post->content) ?></p>
<i>Author: <?= htmlentities($post->author) ?></i><br>
<i><?= substr($post->published_date, 0, 10) ?></i>

<?php include('layouts/footer.php') ?>