<?
#��������� ��������� ���������� ���� �� ������ � ������
define('LANG_DIR', $_SERVER['DOCUMENT_ROOT']."/lang/", false);
#��������� - ���� �� �������
define('TPL_DIR', $_SERVER['DOCUMENT_ROOT']."/templates/", false);

#��������� ���������� ���-������ �� ����, ���� ����, �� ������ ru 
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