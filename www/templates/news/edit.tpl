{if $action eq 'edit'}
<div class="jipTitle">Редактирование новости ID: {$news->getId()} ({$news->getTitle()|substr:0:25}...)</div>
{else}
<div class="jipTitle">Создание новости</div>
{literal}<script type="text/javascript">
Calendar.setup({"ifFormat":"%H:%M:%S %d/%m/%Y","daFormat":"%d/%m/%Y","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":24, "align":"BR", "inputField":"calendar-field-created","button":"calendar-trigger-created"});
</script>{/literal}
{/if}

<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td style='width: 20%;'>{$form.title.label}</td>
        <td style='width: 80%;'>{$form.title.html}</td>
    </tr>
    {if $action ne 'edit'}
    <tr>
        <td>{$form.created.label}</td>
        <td>{$form.created.html} <button type="button" id="calendar-trigger-created" class="calendar_button"><img src="{$SITE_PATH}/templates/images/calendar.png" /></button></td>
    </tr>
    {/if}
    <tr>
        <td style='vertical-align: top;'>{$form.text.label}</td>
        <td>{$form.text.html}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>{$form.submit.html} {$form.reset.html}</td>
    </tr>
</table>
</form>