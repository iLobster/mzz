{add file="jscalendar/calendar.js"}{add file="jscalendar/calendar-ru.js"}{add file="jscalendar/calendar-setup.js"}

<div id="jipTitle">
<div class="jipMove">&nbsp;</div>
{if $action eq 'edit'}Редактирование новости{else}Создание новости{/if}
</div>


<form {$form.attributes} onsubmit="return sendFormWithAjax(this);return false;">
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    {if $action eq 'edit'}
    <tr>
        <td style='width: 15%;'>ID:</td>
        <td style='width: 85%;'>{$news->getId()}</td>
    </tr>
    {/if}
    <tr>
        <td>{$form.title.label}</td>
        <td>{$form.title.html}</td>
    </tr>
    <tr>
        <td>{$form.created.label}</td>
        <td>{$form.created.html} <button type="button" id="calendar-trigger-created" class="calendar_button"><img src="{$SITE_PATH}/templates/images/calendar.png" /></button></td>
    </tr>



    <tr>
        <td>&nbsp;</td>
        <td>{$form.text.html}</td>
    </tr>
    <tr>
        <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
    </tr>
</table>
</form>

{javascript}
{literal}
Calendar.setup({"ifFormat":"%Y-%m-%d %H:%M:%S","daFormat":"%Y/%m/%d","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":24, "align":"BR", "inputField":"calendar-field-created","button":"calendar-trigger-created"});
{/literal}
{/javascript}