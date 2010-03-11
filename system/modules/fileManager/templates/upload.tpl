{if !$validator->isValid() or $success eq true}
<div id="status">{if $success}1{else}0{/if}</div>
<div id="messages">
    {foreach from=$messages item=message}
        <span>{$message}</span>
    {/foreach}
</div>
{else}
<div class="jipTitle">Загрузка файла в каталог {$folder->getTitle()}</div>

{literal}
<script type="text/javascript">
    var cb = {submit: function() {$j('#fmUploadSubmit').attr('disabled', true); $j("#fmStatus").hide().empty();},
              complete: function() {$j('#fmUploadSubmit').attr('disabled', false);},
              error: function(messages) { var t = $j("#fmStatus"); var u = $j("<ul style='margin-bottom: 0px'>"); t.empty().show().append(u);
                                          $j.each(messages, function(){u.append("<li>" + this + "</li>");});
                                         },
              success: function(){jipWindow.refreshAfterClose(true);jipWindow.close();}
              };

    fileLoader.loadJS(SITE_PATH + '/js/fileManager/fileUpload.js', function() {fileUpload.create('fmUpload', cb);});
</script>
{/literal}
<div id="fmStatus" style="display: none; padding: 5px; border: 1px solid #FBC4C4; background-color: #FDDFDF; color: #840909; font-weight: bold"></div>

{form action=$form_action method="post" class="mzz-jip-form" id="fmUpload"}
<div class="field">
    <div class="label">
        {form->caption name="path" value="Каталог"}
    </div>
    <div class="text">
        {$folder->getTreePath()}
    </div>
</div>
<div class="field{$validator->isFieldRequired('file', ' required')}{$validator->isFieldError('file', ' error')}">
    <div class="label">
        {form->caption name="file" value="Файл"}
    </div>
    <div class="text">
        {form->file name="file"}
        <span class="caption>{if $folder->getFilesize() > 0}<br />Ограничение на размер загружаемого файла: <b>{$folder->getFilesize()}</b> Мб{/if}{assign var=exts value=$folder->getExts()}{if not empty($exts)}<br />Ограничение на расширения файлов: <b>{$folder->getExts()}</b>{/if}</span>
        <span class="caption error">{$validator->getFieldError('file')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('name', ' required')}{$validator->isFieldError('name', ' error')}">
    <div class="label">
        {form->caption name="name" value="Новое имя"}
    </div>
    <div class="text">
        {form->text name="name"}
        <span class="caption error">{$validator->getFieldError('name')}</span>
    </div>
</div>
<div class="field{$validator->isFieldRequired('about', ' required')}{$validator->isFieldError('about', ' error')}">
    <div class="label">
        {form->caption name="about" value="Описание"}
    </div>
    <div class="text">
        {form->textarea name="about" rows="7"}
        <span class="caption error">{$validator->getFieldError('about')}</span>
    </div>
</div>
<div class="field">
    <div class="text">
        {form->checkbox name="header" value=0} {form->caption name="header" value="Отдавать с нужными заголовками"}
    </div>
</div>
<div class="field">
    <div class="text">
        {form->checkbox name="direct_link" value=0} {form->caption name="direct_link" value="Давать прямую ссылку на скачивание"}
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" id="fmUploadSubmit" value="Загрузить"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>
{/if}