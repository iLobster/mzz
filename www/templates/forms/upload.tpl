<iframe name="{$name}UploadFile" id="{$name}UploadFile" style="border: 0; width: 0; height: 0;" src="about:blank"></iframe>
<div id="{$name}UploadStatus" class="uploadSuccess" style="display: none;"></div>
<div id="{$name}UploadStatusError" style="display: none;" class="uploadError"></div>
<script type="text/javascript">
    fileLoader.loadJS(SITE_PATH + "/templates/js/upload.js");
    fileLoader.onJsLoad(function () {ldelim} mzzResetUploadForm('{$name}'); {rdelim});
</script>
