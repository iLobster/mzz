<div class="jipTitle">{if $isEdit}��������������{else}��������{/if}</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="title" value="���������:"}</td>
            <td>{form->text name="title" size="60" value=$item->getTitle()}{$errors->get('title')}</td>
        <tr>
        <tr>
            <td>{form->caption name="url" value="������:"}</td>
            <td>{form->text name="url" size="60" value=$item->getPropertyValue('url')}{$errors->get('url')}</td>
        <tr>
        <tr>
            <td>{form->submit name="submit" value="���������"}</td><td>{form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>