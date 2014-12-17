<?
ini_set('default_charset', 'UTF-8');
//Скрипт проверки
	
#ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)
include("db.php");

if(isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
	$query = mysqli_query($link, "SELECT * FROM users WHERE user_id = '".intval($_COOKIE['id'])."'");
	$userdata = mysqli_fetch_assoc($query);
	
	if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']))
	{
		setcookie("id", "", time()-3600*24*30*12, "/");
		setcookie("hash", "", time()-3600*24*30*12, "/");
		
		print "Что-то пошло не так...<br>";
		print "Попробуйте <a href='http://test.loc/login.php'>войти</a> снова.";
	}
	else
	{
		if ($file == 1) $file = "Ваш файл успешно загружен!";
		print "Привет, ".$userdata['user_login'].$file;
	}
}
else
{
	print "Возможно у вас отключены куки, включите их и попробуйте <a href='http://test.loc/login.php'>войти</a>снова.";
}	
?>