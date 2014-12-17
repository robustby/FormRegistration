<?
ini_set('default_charset', 'UTF-8');
#Подключение скрипта языка
include("modules/lang.php");

//Страница авторизации

#ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)
include("modules/db.php");

#Функция для генерации случайной строки

function generateCode($length=6)
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
	$code = "";
	
	$clen = strlen($chars) - 1;
	while(strlen($code) < $length)
	{
		$code .= $chars[mt_rand(0,$clen)];
	}
	return $code;
}

if(isset($_POST['submit']))
{
	# Получаем из БД запись, у которой логин равняется введенному
	
	$query = mysqli_query($link, "SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
	$data = mysqli_fetch_assoc($query);
	
	#Сравниваем пароли
	
	if($data['user_password'] === md5(md5($_POST['password'])))
	{
		#Генерируем случайное число и шифруем его
		
		$hash = md5(generateCode(10));
		
		#записываем в БД новый хеш авторизации и IP
		mysqli_query($link, "UPDATE users SET user_hash='".$hash."' WHERE user_id='".$data['user_id']."'");
		
		#Записываем куки
		
		setcookie("id", $data['user_id'], time()+60*60*24*30);
		setcookie("hash", $hash, time()+60*60*24*30);
		
		#Переадресовываем браузер на страницу проверки скрипта
		
		header("Location: modules/check.php?file=$suc"); exit();
	}
	else
	{
		if ($lang == 'ru'){
			print "Вы ввели неправильный логин или пароль!";
		}else print "Your password or login is not correct!";		
	}
}

#Подключение шаблона
include("templates/login.html");
?>