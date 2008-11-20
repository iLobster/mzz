{if $isEdit}
    <div class="jipTitle">Редактирование каталога</div>
{else}
    <div class="jipTitle">Создание каталога</div>
{/if}

{form action=$action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 30%;'>{form->caption name="name" value="Идентификатор" onError="<strong>%s</strong>"}</td>
            <td style='width: 70%;'>{form->text name="name" value=$folder->getName() size="40" onError="style=border: 2px solid red;"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="title" value="Название"}</td>
            <td style='width: 70%;'>{form->text name="title" value=$folder->getTitle() size="40"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="filesize" value="Максимальный размер файла (в Мб)"}</td>
            <td style='width: 70%;'>{form->text name="filesize" value=$folder->getFilesize() size="40"}{$errors->get('filesize')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="exts" value='Разрешённые расширения:<br /><span style="font-size: 90%; color: #777;">(разделённые знаком ";")</span>'}</td>
            <td style='width: 70%;'>{form->text name="exts" value=$folder->getExts() size="40"}{$errors->get('exts')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="storage" value='Сторадж:'}</td>
            <td style='width: 70%;'>{form->select name="storage" options=$storages value=$folder->getStorage()->getId()}{$errors->get('storage')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>