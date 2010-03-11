{if $isEdit}
    <div class="jipTitle">Редактирование каталога</div>
{else}
    <div class="jipTitle">Создание каталога</div>
{/if}

{form action=$action method="post" jip=true class="mzz-jip-form"}
<div class="field{$validator->isFieldRequired('name', ' required')}{$validator->isFieldError('name', ' error')}">
    <div class="label">
        {form->caption name="name" value="Идентификатор"}
    </div>
    <div class="text">
        {form->text name="name" value=$folder->getName()}
        <span class="caption error">{$validator->getFieldError('name')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('title', ' required')}{$validator->isFieldError('title', ' error')}">
    <div class="label">
        {form->caption name="title" value="Название"}
    </div>
    <div class="text">
        {form->text name="title" value=$folder->getTitle() style="width: 100%"}
        <span class="caption error">{$validator->getFieldError('title')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('filesize', ' required')}{$validator->isFieldError('filesize', ' error')}">
    <div class="label">
        {form->caption name="filesize" value="Максимальный размер файла (в Мб)"}
    </div>
    <div class="text">
        {form->text name="filesize" value=$folder->getFilesize() style="width: 100px"}
        <span class="caption error">{$validator->getFieldError('filesize')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('exts', ' required')}{$validator->isFieldError('exts', ' error')}">
    <div class="label">
        {form->caption name="exts" value="Разрешённые расширения"}
    </div>
    <div class="text">
        {form->text name="exts" value=$folder->getExts() style="width: 100%"}
        <span class="caption">расширения разделяются ";"</span>
        <span class="caption error">{$validator->getFieldError('exts')}</span>
    </div>
</div>
<div class="field">
    <div class="label{$validator->isFieldRequired('storage', 'required')} {$validator->isFieldError('storage', 'error')}">
        {form->caption name="storage" value='Сторадж'}
    </div>
    <div class="text">
        {if $folder->getStorage()}{assign storage_id=$folder->getStorage()->getId()}{else}{assign storage_id=0}{/if}
        {form->select name="storage" options=$storages value=$storage_id}
        <span class="caption error">{$validator->getFieldError('storage')}</span>
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>