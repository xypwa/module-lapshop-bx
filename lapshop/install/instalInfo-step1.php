<?
use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

Loc::loadMessages(__FILE__);
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="lapshop">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">

    <p><?= Loc::getMessage("REINSTALL_DB") ?></p>
    <p><input type="checkbox" name="REINSTALL_DB" id="REINSTALL_DB" value="Y" checked><label for="REINSTALL_DB"><?= Loc::getMessage("REINSTALL_DB_BTN") ?></label></p>

    <input type="submit" name="" value="Ok">
</form>