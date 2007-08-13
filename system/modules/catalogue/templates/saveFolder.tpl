<div class="jipTitle">{if $isEdit}Редактирование папки{else}Создание папки{/if}</div>
<form action="{$action}" method="POST" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 15%;'>{form->caption name="title" value="Заголовок:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</td>
            <td style='width: 85%;'>{form->text name="title" size="60" value=$folder->getTitle() onError="style=border: red 1px solid;"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td>{form->caption name="name" value="Имя:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</td>
            <td>{form->text name="name" size="60" value=$folder->getName() onError="style=border: red 1px solid;"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td>{form->caption name="defaultType" value="Тип по-умолчанию:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</td>
            <td>{form->select name="defaultType" value=$folder->getDefType() options=$types onError="style=border: red 1px solid;"}{$errors->get('defaultType')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:left;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
