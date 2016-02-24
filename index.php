<?php

require_once('config.php');
require_once('functions.php');

session_start();


if(empty($_SESSION['id']))
{
    header('Location: login.php');
    exit;
}



$dbh = connectDb();
$sql = "select * from posts order by updated_at desc";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  <title>たじろぐ</title>
</head>
<body>
<nav class="navbar navbar-inverse">
<div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collape" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
 <a class="navbar-brand" href="./index.php">たじろぐ</a>
       </div>

       <div class="collaspe navbar-collaspe" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="add.php">投稿する</a></li>
 </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
<div class="container">

  <?php echo $_SESSION['name'] ?>さん、こんにちは
  <p><a href="logout.php">ログアウト</a></p>
 <!-- <a href="add.php">新規投稿記事</a> -->
  <h1>記事一覧</h1>
  <?php if (count($posts)) : ?>
    <?php foreach ($posts as $post) : ?>
      <li style="list-style-type: none;">
        <h4><a href="show.php?id=<?php echo h($post['id']) ?>"><?php echo h($post['title']) ?>@<?php echo h($_SESSION['name'])?></h4></a><br>
        <?php echo h($post['body']) ?><br>
        投稿日時: <?php echo h($post['updated_at']) ?>
        <hr>
      </li>
    <?php endforeach; ?>
  <?php else : ?>
    投稿された記事はありません
  <?php endif; ?>
  </div>


</body>
</html>