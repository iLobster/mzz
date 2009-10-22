{if $isEdit}
    <div class="jipTitle">Редактирование каталога</div>
{else}
    <div class="jipTitle">Создание каталога</div>
{/if}

{form action=$action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$validator->isFieldRequired('name', 'required')} {$validator->isFieldError('name', 'error')}">
            {form->caption name="name" value="Идентификатор"}
            <span class="input">{form->text name="name" value=$folder->getName() style="width: 100%"}</span>
            {if $validator->isFieldError('name')}<span class="error">{$validator->getFieldError('name')}</span>{/if}
        </li>
        <li class="{$validator->isFieldRequired('title', 'required')} {$validator->isFieldError('title', 'error')}">
            {form->caption name="title" value="Название"}
            <span class="input">{form->text name="title" value=$folder->getTitle() style="width: 100%"}</span>
            {if $validator->isFieldError('title')}<span class="error">{$validator->getFieldError('title')}</span>{/if}
        </li>
        <li class="{$validator->isFieldRequired('filesize', 'required')} {$validator->isFieldError('filesize', 'error')}">
            {form->caption name="filesize" value="Максимальный размер файла (в Мб)"}
            <span class="input">{form->text name="filesize" value=$folder->getFilesize() style="width: 100%"}</span>
            {if $validator->isFieldError('filesize')}<span class="error">{$validator->getFieldError('filesize')}</span>{/if}
        </li>
        <li class="{$validator->isFieldRequired('exts', 'required')} {$validator->isFieldError('exts', 'error')}">
            {form->caption name="exts" value="Разрешённые расширения"}
            <span style="font-size: 90%; color: #777;">(разделённые знаком ";")</span>
            <span class="input">{form->text name="exts" value=$folder->getExts() style="width: 100%"}</span>
            {if $validator->isFieldError('exts')}<span class="error">{$validator->getFieldError('exts')}</span>{/if}
        </li>
        <li class="{$validator->isFieldRequired('storage', 'required')} {$validator->isFieldError('storage', 'error')}">
            {if $folder->getStorage()}{assign storage_id=$folder->getStorage()->getId()}{else}{assign storage_id=0}{/if}
            {form->caption name="storage" value='Сторадж'}
            <span class="input">{form->select name="storage" options=$storages value=$storage_id}</span>
            {if $validator->isFieldError('storage')}<span class="error">{$validator->getFieldError('storage')}</span>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
</form>