<div class="jipTitle">{if $isEdit}Редактирование{else}Создание пункта в категории "{$category->getTitle()}"{/if}</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="question" value="Вопрос:"}</td>
            <td>{form->text name="question" size="60" value=$faq->getQuestion()}{$errors->get('question')}</td>
        <tr>
        <tr>
            <td>{form->caption name="answer" value="Ответ:"}</td>
            <td>{form->textarea name="answer" value=$faq->getAnswer()|htmlspecialchars style="width: 50%; height: 150px;"}{$errors->get('answer')}</td>
        <tr>
        <tr>
            <td style="text-align:left;">{form->submit name="submit" value="Сохранить"} {form->reset jip="true" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>