<?php
/*
 * Файл local/modules/scrollup/options.php
 */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Xypw\Lapshop;


global $APPLICATION;

Loc::loadMessages(__FILE__);


// получаем идентификатор модуля
$request = HttpApplication::getInstance()->getContext()->getRequest();
$module_id = htmlspecialchars($request['mid'] != '' ? $request['mid'] : $request['id']);

$groupRight = $APPLICATION->GetGroupRight($module_id);

// подключаем наш модуль
try {
    Loader::includeModule($module_id);

    $wa = new Lapshop\App();
    echo 'Модуль найден';
} catch (\Bitrix\Main\LoaderException $e) {
    echo "Модуль не найден"; die;
}
/*
 * Параметры модуля со значениями по умолчанию
 */
$aTabs = array(
    array(
        /*
         * Первая вкладка «Основные настройки»
         */
        'DIV'     => 'edit_main',
        'TAB'     => "Основные настройки",//Loc::getMessage('SCROLLUP_OPTIONS_TAB_GENERAL'),
        'TITLE'   => "", //Loc::getMessage('SCROLLUP_OPTIONS_TAB_GENERAL'),
        'OPTIONS' => array(

        )
    ),
    array(
        /*
         * Первая вкладка «Основные настройки»
         */
        'DIV'     => 'editsettings',
        'TAB'     => "Доп. настройки",
        'TITLE'   => "",
        'OPTIONS' => array(

        )
    ),
);

/*
 * Создаем форму для редактирвания параметров модуля
 */
$tabControl = new CAdminTabControl(
    'tabControl',
    $aTabs
);

?>




<?php
$tabControl->end();

/*
 * Обрабатываем данные после отправки формы
 */
if ($request->isPost() && check_bitrix_sessid()) {

}
?>