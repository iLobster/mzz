<div class="jipTitle">{if $isEdit}Редактирование{else}Создание{/if}</div>
{literal}<script type="text/javascript">
function addOne()
{
    var tbody = $('selectvariants');
	var tr = tbody.insertRow(tbody.rows.length);
	var td = tr.insertCell(tr.cells.length);
    
    var newInput = document.createElement('input');
    newInput.name = 'answers[]';
	newInput.type = "text";
    
    td.width = '20%';
	//td.innerHTML = '<input type="text" name="answers[]">';
	td.appendChild(newInput);
	td = tr.insertCell(tr.cells.length);
	td.width = '80%';

    var newType = document.createElement('select');
    newType.name = 'answers_type[]';
    {/literal}{foreach from=$answers_types item="type" key="id"}
    newType.options[{$id}] = new Option("{$type}", "{$id}");
    {/foreach}{literal}
	var newImg = document.createElement('img');
	newImg.src = SITE_PATH + "/templates/images/delete.gif";
	newImg.onclick = function () {
	    deleteOne(this.parentNode.parentNode);
	}

	td.appendChild(newType);
	td.appendChild(newImg);
    
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
                    <td width="20%">{form->text name="answers[$answerId]" value=$answer->getTitle()}</td>
                    <td width="80%">{form->select name="answers_type[$answerId]" value=$answer->getType() options=$answers_types}<img src="{$SITE_PATH}/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" /></td>
                </tr>
            {/foreach}
        </tbody>
    </table>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip="true" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>