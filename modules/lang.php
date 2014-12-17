<?
#объявляем константу содержащую путь до файлов с языком
define('LANG_DIR', $_SERVER['DOCUMENT_ROOT']."/lang/", false);
#константа - путь до конфига
define('TPL_DIR', $_SERVER['DOCUMENT_ROOT']."/templates/", false);

#Проверяем полученный гет-запрос на язык, если нету, то ставим ru 
if (isset($_GET['lang'])){
	$lang = $_GET['lang'];
	include_once(LANG_DIR.$lang.'.php');
	include_once(TPL_DIR.$lang.'.php');
}else{
	$lang = 'ru';
	include_once(LANG_DIR.$lang.'.php');
	include_once(TPL_DIR.$lang.'.php');
}
?>