<div class="jipTitle">{if $isEdit}��������������{else}��������{/if}</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="question" value="������:"}</td>
            <td>{form->text name="question" size="60" value=$vote->getQuestion()}{$errors->get('question')}</td>
        <tr>
        <tr>
            <td>{form->caption name="name" value="���:"}</td>
            <td>{form->text name="name" size="60" value=$vote->getName()}{$errors->get('name')}</td>
        <tr>
        <tr>
            <td>{form->submit name="submit" value="���������"}</td><td>{form->reset jip="true" name="reset" value="������"}</td>
        </tr>
    </table>
</form>