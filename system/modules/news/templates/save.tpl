{if $isEdit}
    <div class="jipTitle">Редактирование новости ID: {$news->getId()} ({$news->getTitle()|htmlspecialchars|substr:0:25}...)</div>
{else}
    <div class="jipTitle">Создание новости</div>
    {literal}<script type="text/javascript">
    Calendar.setup({"ifFormat":"%H:%M:%S %d/%m/%Y","daFormat":"%d/%m/%Y","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":24, "align":"BR", "inputField":"calendar-field-created","button":"calendar-trigger-created"});
    </script>{/literal}
{/if}

<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="title" value="Название" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="title" value=$news->getTitle() size="60"}{$errors->get('title')}</td>
        </tr>
        {if !$isEdit}
            <tr>
                <td>Дата создания:</td>
                <td>{form->text name="created" size="20" id="calendar-field-created" value=$smarty.now|date_format:"%H:%M:%S %d/%m/%Y"} <button type="button" id="calendar-trigger-created" class="calendar_button"><img src="{$SITE_PATH}/templates/images/calendar.png" /></button>{$errors->get('created')}</td>
            </tr>
        {/if}
        <tr>
            <td style='vertical-align: top;'>Аннотация</td>
            <td>{form->textarea name="annotation" value=$news->getAnnotation() rows="4" cols="50"}</td>
        </tr>
        <tr>
            <td style='vertical-align: top;'>Текст</td>
            <td>{form->textarea name="text" value=$news->getText() rows="7" cols="50"}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>