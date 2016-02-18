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

        if($row)
        {
          $_SESSION['id'] = $row['id'];
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
 </head>
 <body>
      <h1>ログイン</h1>
      <form action="" method="post">
      <p>名前: <input type="text" name="name" value="<?= $_POST['name']?>"></p>
      <p>パスワード:<input type="password" name="password"></p>
      <input type="submit" value="ログイン"><br>
      <a href="signup.php">新規登録</a>
 </body>
 </html>