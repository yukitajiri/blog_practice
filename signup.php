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
        $errors['email'][] = 'メールアドレスが未入力です';
    }

    if(empty($password))
    {
        $errors['password'][] = 'パスワードが未入力です';
    }

 if(! filter_var($email, FILTER_VALIDATE_EMAIL))
       {
             // echo '正しくないメールアドレスです';
              $errors['email'][] = 'メールアドレスの形式ではないです';
        }
// パスワードの文字と文字数のバリデーション
  if(!preg_match("/[\@-\~]/", $password))
  {
        $errors['password'][] = 'パスワードは半角英数字及び記号のみ入力してください';
  }
  // // Fatal error: Call to undefined function mb_strlen() in /var/www/html/blog_practice/signup.php on line 40というエラー
  // elseif(mb_strlen($password) < 4 )
  // {
  //       $errors['password'][] = 'パスワードは4文字以上で設定してください';
  // }
  // elseif(mb_strlen($password) > 32)
  // {
  //       $errors['password'][] = 'パスワードは32文字以下で設定してください';

  // }
// var_dump($errors);

    // バリデーション突破
    if(empty($errors))
    {
        $dbh = connectDb();
        $sql = "insert into users (name, email, created_at, password) values (:name, :email, now(), :password)
        ";
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
      <?php foreach ($errors['email'] as $error) :?>
          <?php echo h($error) ?>
      <?php endforeach ?>
    <?php endif ?>
      <p>パスワード:<input type="text" name="password"></p>
      <?php if($errors['password']) :?>
        <?php foreach($errors['password'] as $error_pw) :?>
        <?php echo h($error_pw) ?><br>
        <?php endforeach ?>
      <?php endif ?>
      <input type="submit" value="新規登録"><br>
      <a href="login.php">ログイン画面へ</a>
  </body>
</html>
