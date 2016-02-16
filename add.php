<?php

require_once('config.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $body = $_POST['body'];
  $title = $_POST['title'];
  $errors = array();

  // バリデーション
  if ($title == '') {
    $errors['title'] = 'タイトルが未入力です';
  }

  if ($body == '') {
    $errors['body'] = 'メッセージが未入力です';
  }

  // バリデーションを突破したあとの処理
  if (empty($errors)) {
    // データを追加する
    $dbh = connectDb();
    $sql = "insert into posts (body, title, created_at, updated_at) values
    (:body, :title, now(), now())";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":body", $body);
    $stmt->bindParam(":title", $title);
    $stmt->execute();

    header('Location: index.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規記事投稿</title>
</head>
<body>
  <h1>新規記事投稿</h1>
  <p><a href="index.php">戻る</a></p>
  <?php if ($errors) : ?>
    <?php foreach ($errors as $error) : ?>
      <li>
        <?php echo h($error); ?>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
  <form action="" method="post">
    <p>
      タイトル<br>
      <input type="text" name="title">
    </p>
    <p>
      本文<br>
      <textarea name="body" cols="30" rows="5"></textarea>
    </p>
    <p><input type="submit" value="投稿する"></p>
  </form>
</body>
</html>
