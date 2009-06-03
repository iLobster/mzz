{if !$form->isValid()}
<div id="fmUploadStatusError">
<ul>
{foreach from=$form->export() item=formError}
    <li>{$formError}</li>
{/foreach}
</ul></div>
{elseif isset($success) && isset($file_name)}
<div id="fmUploadStatus">Файл {$file_name} загружен.</div>
{else}
{assign var="folderTitle" value=$folder->getTitle()}
<div class="jipTitle">Загрузка файла в каталог {$folderTitle}</div>

{form action=$form_action method="post" class="mzz-jip-form" enctype="multipart/form-data"} {* ajaxUpload="fm" *}
    <ul>
        <li>
            {form->caption name="path" value="Каталог"}
            <span class="input">{$folder->getTreePath()}</span>
        </li>
        <li class="{$form->required('file', 'required')} {$form->error('file', 'error')}">
            {form->caption name="file" value="Файл"}
            <span class="input">{form->file name="file"}</span>
            <span style="text-align:center; color: #999; font-size: 90%;">
                {if $folder->getFilesize() > 0}<br />Ограничение на размер загружаемого файла: <b>{$folder->getFilesize()}</b> Мб{/if}
                {assign var=exts value=$folder->getExts()}
                {if not empty($exts)}<br />Ограничение на расширения файлов: <b>{$folder->getExts()}</b>{/if}
            </span>
            {if $form->error('file')}<span class="error">{$form->message('file')}</span>{/if}
        </li>
        <li class="{$form->required('name', 'required')} {$form->error('name', 'error')}">
            {form->caption name="name" value="Новое имя"}
            <span class="input">{form->text name="name" style="width: 100%"}</span>
            {if $form->error('name')}<span class="error">{$form->message('name')}</span>{/if}
        </li>
        <li class="{$form->required('about', 'required')} {$form->error('about', 'error')}">
            {form->caption name="about" value="Описание"}
            <span class="input">{form->textarea name="about" rows="7" style="width: 100%"}</span>
            {if $form->error('about')}<span class="error">{$form->message('about')}</span>{/if}
        </li>
        <li>
            {form->caption name="header" value="Отдавать с нужными заголовками"}
            <span class="input">{form->checkbox name="header" value=0}</span>
        </li>
        <li>
            {form->caption name="direct_link" value="Давать прямую ссылку на скачивание"}
            <span class="input">{form->checkbox name="direct_link" value=0}</span>
        </li>
    </ul>
    <span class="buttons">{form->submit name="submit" id="fmUploadSubmitButton" value="Загрузить"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>
{/if}