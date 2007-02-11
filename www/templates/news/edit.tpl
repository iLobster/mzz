{if $action eq 'edit'}
{include file='jipTitle.tpl' title='Редактирование новости'}
{else}
{include file='jipTitle.tpl' title='Создание новости'}
{/if}

<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
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

{literal}<script type="text/javascript">
Calendar.setup({"ifFormat":"%H:%M:%S %d/%m/%Y","daFormat":"%d/%m/%Y","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":24, "align":"BR", "inputField":"calendar-field-created","button":"calendar-trigger-created"});
</script>{/literal}