{if $isEdit}
    <div class="jipTitle">Редактирование каталога</div>
{else}
    <div class="jipTitle">Создание каталога</div>
{/if}

{form action=$action method="post" jip=true class="mzz-jip-form"}
    <ul>
        <li class="{$form->required('name', 'required')} {$form->error('name', 'error')}">
            {form->caption name="name" value="Идентификатор"}
            <span class="input">{form->text name="name" value=$folder->getName() style="width: 100%"}</span>
            {if $form->error('name')}<span class="error">{$form->get('name')}</span>{/if}
        </li>
        <li class="{$form->required('title', 'required')} {$form->error('title', 'error')}">
            {form->caption name="title" value="Название"}
            <span class="input">{form->text name="title" value=$folder->getTitle() style="width: 100%"}</span>
            {if $form->error('title')}<span class="error">{$form->get('title')}</span>{/if}
        </li>
        <li class="{$form->required('filesize', 'required')} {$form->error('filesize', 'error')}">
            {form->caption name="filesize" value="Максимальный размер файла (в Мб)"}
            <span class="input">{form->text name="filesize" value=$folder->getFilesize() style="width: 100%"}</span>
            {if $form->error('filesize')}<span class="error">{$form->get('filesize')}</span>{/if}
        </li>
        <li class="{$form->required('exts', 'required')} {$form->error('exts', 'error')}">
            {form->caption name="exts" value="Разрешённые расширения"}
            <span style="font-size: 90%; color: #777;">(разделённые знаком ";")</span>
            <span class="input">{form->text name="exts" value=$folder->getExts() style="width: 100%"}</span>
            {if $form->error('exts')}<span class="error">{$form->get('exts')}</span>{/if}
        </li>
        <li class="{$form->required('storage', 'required')} {$form->error('storage', 'error')}">
        {if $folder->getStorage()}
        {assign storage_id=$folder->getStorage()->getId()}
        {else}
        {assign storage_id=0}
        {/if}
            {form->caption name="storage" value='Сторадж'}
            <span class="input">{form->select name="storage" options=$storages value=$storage_id}</span>
            {if $form->error('storage')}<span class="error">{$form->get('storage')}</span>{/if}
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
</form>