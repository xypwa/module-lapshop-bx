<?
use Bitrix\Main\Localization\Loc;

//if (!check_bitrix_sessid()) {
//    return;
//}
Loc::loadMessages(__FILE__);
if ($errorException = $APPLICATION->getException()) {
    CAdminMessage::showMessage(
        Loc::getMessage('INSTALL_FAILED') . ': ' . $errorException->GetString()
    );
} else {
    CAdminMessage::showNote(
        Loc::getMessage('INSTALL_SUCCESS')
    );
}
?>
<!-- Кнопка возврата к списку модулей -->
<form action="<?= $APPLICATION->getCurPage(); ?>">
    <input type="submit" value="<?= Loc::getMessage('RETURN_MODULES'); ?>">
</form>