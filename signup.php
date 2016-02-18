<?php
require_once('config.php');
require_once('functions.php');

if($_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = array();

// バリデーション
    if(empty($name))
    {
        $errors['name'] = '名前が未入力です';
    }

    if(empty($email))
    {
        $errors['email'] = 'メールアドレスが未入力です';
    }

    if(empty($password))
    {
        $errors['password'] = 'パスワードが未入力です';
    }



    // バリデーション突破
    if(empty($errors))
    {
        $dbh = connectDb();
        $sql = "insert into users (name, email, created_at, password) values (:name, :email, now(), :password)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);

        $stmt->execute();

        header('Location: login.php');
        exit;

      }
}

?>





<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新規登録画面</title>
  </head>
  <body>
<h1>新規登録画面</h1>
      <form action="" method="post">
      <p>名前: <input type="text" name="name"></p>
      <?php if($errors['name']) :?>
        <?php echo h($errors['name']) ?>
      <?php endif ?>

      </p>
      <p>メールアドレス:<input type="text" name="email"></p>
      <?php if($errors['email']) :?>
        <?php echo h($errors['email']) ?><br>
      <?php endif ?>
      <p>パスワード:<input type="text" name="password"></p>
      <input type="submit" value="新規登録"><br>
      <a href="login.php">ログイン画面へ</a>
  </body>
</html>
