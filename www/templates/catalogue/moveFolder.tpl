<div class="jipTitle">Перемещение каталога `{$folder->getPath()}`</div>
<form action="{$action}" method="POST" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="dest" value="Каталог назначения" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</td>
            <td>{form->select name="dest" size="5" value='' options=$select onError="style=border: red 1px solid;"}{$errors->get('dest')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset onclick="javascript: jipWindow.close();" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>