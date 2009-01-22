<div class="jipTitle">{if $isEdit}Редактирование опроса{else}Создание опроса{/if}</div>
{literal}<script type="text/javascript">
function voteAddVariant()
{
    var tbody = $('selectvariants');
    var tr = tbody.insertRow(tbody.rows.length);
    var td = tr.insertCell(tr.cells.length);

    var newInput = new Element('input', {name: 'answers[]', type: 'text'}).setStyle({width: '95%'});
    td.appendChild(newInput);
    td = tr.insertCell(tr.cells.length);
    $(td).setStyle({width: '80%'});

    var newType = new Element('select', {name: 'answers_type[]'});
    {/literal}{foreach from=$answers_types item="type" key="id"}
    newType.options[{$id}] = new Option("{$type}", "{$id}");
    {/foreach}{literal}

    var aElem = new Element('a', {href: '#', title: 'Удалить вариант'});
    var newImg = new Element('img', {src: SITE_PATH + '/templates/images/delete.gif'});
    aElem.appendChild(newImg);
    aElem.observe('click', function() {
        voteDeleteVariant(this);
    });
    td.insert(newType).insert(' ').insert(aElem);

    jipWindow.lockContent();
}

function voteDeleteVariant(elem)
{
    $(elem.up(1)).remove();
}
Calendar.setup({"ifFormat":"%H:%M:%S %d/%m/%Y","daFormat":"%d/%m/%Y","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":24, "align":"BR", "inputField":"calendar-field-created","button":"calendar-trigger-created"});
Calendar.setup({"ifFormat":"%H:%M:%S %d/%m/%Y","daFormat":"%d/%m/%Y","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":24, "align":"BR", "inputField":"calendar-field-expired","button":"calendar-trigger-expired"});
</script>{/literal}
{form action=$action method="post" jip=true}
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="question" value="Вопрос:"}{if $errors->has('question')}<br />{$errors->get('question')}{/if}</td>
        </tr>
        <tr>
            <td>{form->textarea name="question" rows="3" cols="55" value=$question->getQuestion()}</td>
        </tr>
        <tr>
            {if $isEdit}{assign var="calendarvalue" value=$question->getCreated()}{else}{assign var="calendarvalue" value=$smarty.now}{/if}
            <td>{form->caption name="created" value="С:"} {form->text name="created" size="20" id="calendar-field-created" value=$calendarvalue|date_format:"%H:%M:%S %d/%m/%Y"} <button type="button" id="calendar-trigger-created" class="calendar_button"><img src="{$SITE_PATH}/templates/images/calendar.png" /></button>
            {if $isEdit}{assign var="calendarvalue" value=$question->getExpired()}{else}{assign var="calendarvalue" value=$smarty.now+3600}{/if}
            {form->caption name="expired" value="По:"} {form->text name="expired" size="20" id="calendar-field-expired" value=$calendarvalue|date_format:"%H:%M:%S %d/%m/%Y"} <button type="button" id="calendar-trigger-expired" class="calendar_button"><img src="{$SITE_PATH}/templates/images/calendar.png" /></button></td>
        </tr>
        <tr>
            <td style="color: red; font-size: 90%; font-weight: bold;">
            {if $errors->has('created')}{$errors->get('created')}<br />{/if}{$errors->get('expired')}
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="3" width="100%"><br>
        <tr>
            <td colspan="2" style="font-size: 110%; font-weight: bold; ">Ответы (<a href="javascript: voteAddVariant();" class="jsLink">добавить вариант</a>):</td>
        </tr>
        <tbody id="selectvariants">
            {foreach from=$question->getAnswers() item="answer" name="variantsIterator"}
                {assign var="answerId" value=$answer->getId()}
                <tr>
                    <td width="20%">{form->text name="answers[$answerId]" value=$answer->getTitle() style="width:95%;"}</td>
                    <td width="80%">{form->select name="answers_type[$answerId]" value=$answer->getType() options=$answers_types} <a href="#" onclick="javascript: voteDeleteVariant(this);" title="Удалить вариант"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="Удалить вариант" /></a></td>
                </tr>
            {/foreach}
        </tbody>
    </table>
    <br />
    {form->submit name="submit" value="Сохранить"} {form->reset jip="true" name="reset" value="Отмена"}
</form>