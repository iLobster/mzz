<div class="jipTitle">{if $isEdit}��������������{else}�������� ������ � ��������� "{$category->getTitle()}"{/if}</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="question" value="������:"}</td>
            <td>{form->text name="question" size="60" value=$faq->getQuestion()}{$errors->get('question')}</td>
        <tr>
        <tr>
            <td>{form->caption name="answer" value="�����:"}</td>
            <td>{form->textarea name="answer" value=$faq->getAnswer()|htmlspecialchars style="width: 50%; height: 150px;"}{$errors->get('answer')}</td>
        <tr>
        <tr>
            <td style="text-align:left;">{form->submit name="submit" value="���������"} {form->reset jip="true" name="reset" value="������"}</td>
        </tr>
    </table>
</form>