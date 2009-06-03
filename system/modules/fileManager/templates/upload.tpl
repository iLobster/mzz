{if !$errors->isEmpty()}
<div id="fmUploadStatusError">
<ul>
{foreach from=$errors->export() item=formError}
    <li>{$formError}</li>
{/foreach}
</ul></div>
{elseif isset($success) && isset($file_name)}
<div id="fmUploadStatus">Файл {$file_name} загружен.</div>
{else}
{assign var="folderTitle" value=$folder->getTitle()}
{include file='jipTitle.tpl' title="Загрузка файла в каталог $folderTitle"}

{form action=$form_action method="post" ajaxUpload="fm"}
    <table width="99%" border="0" cellpadding="5" cellspacing="0" class="systemTable" align="center">
        <tr>
            <td width="25%">Системный путь</td>
            <td width="75%">{$folder->getTreePath()}</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">{form->caption name="file" value="Файл"}</td>
            <td>{form->file name="file"}{$errors->get('file')}
            <span style="text-align:center; color: #999; font-size: 90%;">
                {if $folder->getFilesize() > 0}<br />Ограничение на размер загружаемого файла: <b>{$folder->getFilesize()}</b> Мб{/if}
                {assign var=exts value=$folder->getExts()}
                {if not empty($exts)}<br />Ограничение на расширения файлов: <b>{$folder->getExts()}</b>{/if}
            </span></td>
        </tr>
        <tr>
            <td>{form->caption name="name" value="Новое имя"}</td>
            <td>{form->text name="name"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td>{form->caption name="about" value="Описание"}</td>
            <td>{form->textarea name="about"}{$errors->get('about')}</td>
        </tr>
        <tr>
            <td>{form->caption name="header" value="Отдавать с нужными заголовками"}</td>
            <td>{form->checkbox name="header" value=0}{$errors->get('header')}</td>
        </tr>
        <tr>
            <td>{form->caption name="direct_link" value="Давать прямую ссылку на скачивание"}</td>
            <td>{form->checkbox name="direct_link" value=0}{$errors->get('direct_link')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit id="fmUploadSubmitButton" name="submit" value="Загрузить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
{/if}