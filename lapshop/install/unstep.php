<?php if(!check_bitrix_sessid()) return;
CAdminMessage::ShowNote('Модуль удален');
?>
<form action="<?echo $APPLICATION->GetCurPage()?>">
    <p>
        <input type="hidden" name="lang" value="<?= LANG?>">
        <input type="submit" name="" value="Назад">
    </p>
</form>
