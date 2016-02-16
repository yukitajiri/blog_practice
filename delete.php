<?php
require_once('functions.php');
require_once('config.php');

$id = $_GET['id'];

$dbh = connectDb();
$sql = "select * from posts where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id',$id);
$stmt->execute();
// どうして？
$post = $stmt->fetch();
// postがみつからないときはindexにとばす
if(!$post)
{
        header('Location: inddx.php');
        exit;
}

$sql_delete = "delete from posts where id = :id";
$stmt_delete = $dbh->prepare($sql_delete);
$stmt_delete->bindParam(":id", $id);
$stmt_delete->execute();

header('Location: index.php');
exit;


?>