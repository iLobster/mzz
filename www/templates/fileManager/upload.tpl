<iframe name="_fmUploadFile" style="border: 0;width: 200px;height: 100px;" src="about:blank"></iframe>
<form {$form.attributes} target="_fmUploadFile">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td colspan=2 style="text-align:center;">
                Загрузка файла в каталог <b>{$folder->getPath()}</b>
                {if $folder->getFilesize() > 0}<br />Ограничение на размер загружаемого файла: <b>{$folder->getFilesize()}</b> Мб{/if}
                {assign var=exts value=$folder->getExts()}
                {if not empty($exts)}<br />Ограничение на расширения файлов: <b>{$folder->getExts()}</b>{/if}
            </td>
        </tr>
        <tr>
            <td>{$form.file.label}</td>
            <td>{$form.file.html}{$form.file.error}</td>
        </tr>
        <tr>
            <td>{$form.name.label}</td>
            <td>{$form.name.html}{$form.name.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>
