 <?php
require_once('config.php');
require_once('functions.php');

session_start();

if (!empty($_SESSION['id']))
{
  header('Location: index.php');
  exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = $_POST['name'];
    $password = $_POST['password'];
    $errors = array();

      if(empty($name))
      {
            $errors['name'] = '名前が未入力です';
       }

       if(empty($password))
       {
            $errors['password'] = 'パスワードが未入力です';
       }

      if(empty($errors))
      {
           $dbh = connectDb();
           $sql = "select * from users where name = :name and password = :password";
           $stmt = $dbh->prepare($sql);
           $stmt->bindParam(":name", $name);
           $stmt->bindParam(":password", $password);
           $stmt->execute();

           $row = $stmt->fetch();



// ここでindexに値をとばしている
        if($row)
        {
          $_SESSION['id'] = $row['id'];
          $_SESSION['name'] = $row['name'];
          header('Location: index.php');

          exit;
        }
        else{
                  echo '名前かパスワードが間違っています';
        }
      }

}
 ?>


 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8">
     <title>ログイン画面</title>
     <link rel="stylesheet" type="text/css" href="style.css">
 </head>
 <body>
  <h1 class="heading1">Log In <span class="small-font">ログイン</span></h1>
  <div class="from-box">

    <form action="" method="post">
       <div>
          <p>名前</p>
          <input type="text" name="name" value="<?= $_POST['name']?>">
      </div>
      <div>
      <p>パスワード</p>
      <input type="password" name="password">
      </div>
      <input class="button"type="submit" value="ログイン"><br>
      <a class="button block newaccount" href="signup.php">新規登録</a>

  </div>
</div>
</body>
</html>