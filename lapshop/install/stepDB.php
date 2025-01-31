<?php
if (!check_bitrix_sessid()) {
    return;
}
?>
<form action="<?
echo $APPLICATION->GetCurPage() ?>">
    <p>
        <input type=checkbox name='REINSTALL_DB' id='REINSTALL_DB' value='Y' checked/>
        <label for='REINSTALL_DB'><?= Loc::getMessage('REINSTALL_TABLES') ?></label><br/>

        <input type='hidden' name='install' value='Y'>
        <input type='hidden' name='step' value='2'>

        <input type="hidden" name="lang" value="<?= LANG ?>">
        <input type="submit" name="" value="Назад">
    </p>
</form>
