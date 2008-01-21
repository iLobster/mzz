{assign var="path" value=$file->getFolder()->getPath()}
{assign var="name" value=$file->getName()}
{include file='jipTitle.tpl' title="Редактирование файла `$path`/`$name`"}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="name" value="Новое имя"}</td>
            <td>{form->text name="name" value=$file->getName()}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td>{form->caption name="about" value="Описание"}</td>
            <td>{form->textarea name="about" value=$file->getAbout()}{$errors->get('about')}</td>
        </tr>
        <tr>
            <td>{form->caption name="header" value="Отдавать с нужными заголовками"}</td>
            <td>{form->checkbox name="header" value=$file->getRightHeader()}{$errors->get('header')}</td>
        </tr>
        <tr>
            <td>{form->caption name="direct_link" value="Давать прямую ссылку на скачивание"}</td>
            <td>{form->checkbox name="direct_link" value=$file->getDirectLink()}{$errors->get('direct_link')}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>