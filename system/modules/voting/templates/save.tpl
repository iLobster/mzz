<div class="jipTitle">{if $isEdit}Редактирование{else}Создание{/if}</div>
{literal}<script type="text/javascript">
var count = 0;

function addOne()
{
    var tbody = $('selectvariants');
	var tr = tbody.insertRow(tbody.rows.length);
	var td = tr.insertCell(tr.cells.length);
    
    td.width = '20%';
	td.innerHTML = '<input type="text" name="selectvalues[' + count + ']">';
	td = tr.insertCell(tr.cells.length);
	td.width = '80%';

	var newInput = document.createElement('input');
	newInput.maxLength = 10;
	newInput.name = 'selectvalues[' + count + ']';
	newInput.type = "text";

	var newImg = document.createElement('img');
	newImg.src = SITE_PATH + "/templates/images/delete.gif";
	newImg.onclick = function () {
	    deleteOne(this.parentNode.parentNode);
	}

	td.appendChild(newInput);
	td.appendChild(newImg);
	//td.innerHTML = '<input maxlength="10" name="selectvalues[' + count + ']" type="text" />
	//<img src="/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" />';
    count++;
    jipWindow.lockContent();
}

function deleteOne(trelem)
{
    $('selectvariants').removeChild(trelem);
}
</script>{/literal}
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="question" value="Вопрос:"}</td>
            <td>{form->text name="question" size="60" value=$question->getQuestion()}{$errors->get('question')}</td>
        <tr>
        <tr>
            <td>{form->caption name="name" value="Имя:"}</td>
            <td>{form->text name="name" size="60" value=$question->getName()}{$errors->get('name')}</td>
        <tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <table border="0" cellpadding="0" cellspacing="3" width="100%">
        <tr>
            <td colspan="2"><a href="javascript:addOne();" class="jsLink">Добавить вариант</a></td>
        </tr>
        <tbody id="selectvariants">
            {foreach from=$question->getAnswers() item="answer" name="variantsIterator"}
                {assign var="answerId" value=$answer->getId()}
                <tr>
                    <td width="20%">{form->text name="answer_$answerId" value=$answer->getTitle()}</td>
                    <td width="80%">{form->select name="answer_type_$answerId" options=$answers_types}<img src="{$SITE_PATH}/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" /></td>
                </tr>
            {/foreach}
            <script type="text/javascript">count = {$smarty.foreach.variantsIterator.total+1};</script>
        </tbody>
    </table>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip="true" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>