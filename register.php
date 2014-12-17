<?
ini_set('default_charset', 'UTF-8');
#Подключение скрипта языка
include("modules/lang.php");

//Страница регистрации нового пользователя

#ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)
include("modules/db.php");

if(isset($_POST['submit']))
{
	$err = array();
	$err_eng = array();
	
	#проверяем логин
	
	if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
	{
		$err[] = "Логин может состоять только из букв английского алфавита и цифр";
		$err_eng[] = "You can only use english alphabet and numbers";
	}
	
	if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 20)
	{
		$err[] = "Логин должен быть не меньше 3-х символов и не больше 20";
		$err_eng[] = "Your login must be not less 3 characters and not larger 20";
	}
	
	#проверяем, не существует ли пользователя с таким именем
	
	$query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
	$row = mysqli_fetch_array($query);
	if (!empty($row['user_id']))
	{
		$err[] = "Пользователь с таким логином уже существует в базе данных!";
		$err_eng[] = "User with your login already exists";
	}
	
	#Сверяем пароли
	
	if($_POST['password'] !== $_POST['password2'])
	{
		$err[] = "Пароли не совпадют!";
		$err_eng[] = "Your passwords don't match";
	}
	
	#Загрузка файла на сервер
	$uploaddir = './files/';
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
	if (($_FILES['userfile']['type'] == "image/gif") 
		|| ($_FILES['userfile']['type'] == "image/jpeg")
		|| ($_FILES['userfile']['type'] == "image/png"))
	{
		if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
		{
			$suc = 1;
		}else
		{
			$err[] = "Ошибка при загрузке файла!";
			$err_eng[] = "Uploading file error!";
		}
	}else{
		$err[] = "Возможно загрузить только изображение (jpg,gif,png формата)!";
		$err_eng[] = "You can only upload image (jpg,gif,png format)!";
	}
	
	#Если нет ошибок, то добавляем в БД нового пользователя
	
	if(count($err) == 0)
	{
		$login = $_POST['login'];
		
		#Убераем лишние пробелы и делаем двойное шифрование
		$password = md5(md5(trim($_POST['password'])));
		
		mysqli_query($link, "INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
		header("Location: /login.php?lang=$lang&file=$suc"); exit();
	}
	else
	{
		if ($lang == 'ru')
		{
			print "<b>При регистрации произошли следующие ошибки:</b><br>";
			foreach($err AS $error)
			{
				print $error."<br>";
			}		
		}else
		{
			print "<b>You have same errors:</b><br>";
			foreach($err_eng AS $error)
			{
				print $error."<br>";
			}
		}

	}
}

#Подключение шаблона
include("templates/register.html");
?>