{assign var="albumTitle" value=$album->getName()}
{assign var="photoName" value=$photo->getName()}
{if !$errors->isEmpty()}
    <div id="galleryUploadStatusError">
    <ul>
    {foreach from=$errors->export() item=formError}
        <li>{$formError}</li>
    {/foreach}
    </ul></div>
{elseif isset($success) && isset($photo_name)}
    <div id="galleryUploadStatus">Фотография "{$photo_name}" загружена.</div>
{else}
<div class="jipTitle">{if $isEdit}Редактирование "{$photo->getName()}" из альбома {$albumTitle}{else}Загрузка фото в альбом {$albumTitle}{/if}</div>
{if !$isEdit}
    {form->open action=$form_action method="post" ajaxUpload="gallery"}
{else}
    <form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
{/if}
<table width="99%" border="0" cellpadding="5" cellspacing="0" class="systemTable" align="center">
            {if !$isEdit}<tr>
                <td style="vertical-align: top;">{form->caption name="image" value="Файл"}</td>
                <td>{form->file name="image"}{$errors->get('image')}
                {*<span style="text-align:center; color: #999; font-size: 90%;">
                    {if $folder->getFilesize() > 0}<br />Ограничение на размер загружаемого файла: <b>{$folder->getFilesize()}</b> Мб{/if}
                    {assign var=exts value=$folder->getExts()}
                    {if not empty($exts)}<br />Ограничение на расширения файлов: <b>{$folder->getExts()}</b>{/if}
                </span> *}
                </td>
            </tr>{/if}
            <tr>
                <td>{form->caption name="name" value="Название фотки"}</td>
                <td>{form->text name="name" value="$photoName"}{$errors->get('name')}</td>
            </tr>
            <tr>
                <td colspan=2 style="text-align:center;">{form->submit id="galleryUploadSubmitButton" name="submit" value="Загрузить"} {form->reset jip=true name="reset" value="Отмена"}</td>
            </tr>
            </tr>
        </table>
    </form>
{/if}