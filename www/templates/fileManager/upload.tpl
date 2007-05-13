{assign var="folderTitle" value=$folder->getTitle()}
{include file='jipTitle.tpl' title="Загрузка файла в каталог $folderTitle"}
{if !$errors->isEmpty()}
<div id="uploadStatusError">
<ul>
{foreach from=$errors->export() item=formError}
    <li>{$formError}</li>
{/foreach}
</ul></div>
{else}
<iframe name="fmUploadFile" id="fmUploadFile" style="border: 0;width: 200px;height: 100px;" src="about:blank"></iframe>
<div id="uploadStatus"></div>
<div id="uploadStatusError"></div>
{literal}
<script type="text/javascript">
var fmUploadFileSubmitButtonValue = null;
function readUploadStatus() {
    $('uploadStatus').style.display = 'none';
    $('uploadStatusError').style.display = 'none';
    var fmUploadFile = $('fmUploadFile');
    $('fmUploadFileSubmitButton').disable();;
    fmUploadFileSubmitButtonValue = $('fmUploadFileSubmitButton').value;
    $('fmUploadFileSubmitButton').value = "Загрузка...";

    var frameOnLoadFunction = fmUploadFile.onload = function () {
        var statusDivId = fmUploadFile.contentWindow.document.getElementById('uploadStatusError') ?  'uploadStatusError' : 'uploadStatus';
        $(statusDivId).style.display = 'block';
        $(statusDivId).innerHTML = fmUploadFile.contentWindow.document.getElementById(statusDivId).innerHTML;

        $('fmUploadFileSubmitButton').enable();
        $('fmUploadFileSubmitButton').value = fmUploadFileSubmitButtonValue;
        if (statusDivId == 'uploadStatus') {
            $('fmUploadFileForm').reset();
            jipWindow.refreshAfterClose();
        }
    }

    fmUploadFile.onload = frameOnLoadFunction;
    if(/MSIE/.test(navigator.userAgent)) {
        (fmUploadFile.addEventListener || ('on', fmUploadFile.attachEvent))('on' + 'load', frameOnLoadFunction, false);
    }
}

function fmResetUploadForm() {
    var fmUploadFile = $('fmUploadFile').setStyle({'width': 0, 'height': 0, 'display': 'none'});
    $('uploadStatus').style.display = 'none';
    if (fmUploadFileSubmitButtonValue) {
        $('fmUploadFileSubmitButton').value = fmUploadFileSubmitButtonValue;
        $('fmUploadFileSubmitButton').enable();
    }
}
fmResetUploadForm();
</script>
{/literal}
<form action="{$form_action}" method="post" target="fmUploadFile" onsubmit="readUploadStatus();" enctype="multipart/form-data">
    <table width="99%" border="0" cellpadding="5" cellspacing="0" class="systemTable" align="center">
        <tr>
            <td width="25%">Системный путь</td>
            <td width="75%">{$folder->getPath()}</td>
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
            <td>{form->caption name="header" value="Отдавать с нужными заголовками"}</td>
            <td>{form->checkbox name="header" value=0}{$errors->get('header')}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{form->submit id="fmUploadFileSubmitButton" name="submit" value="Загрузить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
{/if}