<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
      $name = $_POST['name'];
}

?>

<!DOCTYPE html>

<html>
<head>
</head>
<body>
<form action="" method="post">
あなたの名前は<?php echo $name?>です<br>

<input type="text" name="name" value="<?= $_POST['name'] ?>"><br>
<input type="text" name="password">

<input type="submit" value="送信">
</body>
</html>