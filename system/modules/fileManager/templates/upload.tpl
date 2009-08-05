{if !$form->isValid() or $success eq true}
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

    fileLoader.loadJS(SITE_PATH + '/templates/js/fileManager/fileUpload.js', function() {fileUpload.create('fmUpload', cb);});
</script>
{/literal}
<div id="fmStatus" style="display: none; padding: 5px; border: 1px solid #FBC4C4; background-color: #FDDFDF; color: #840909; font-weight: bold"></div>

{form action=$form_action method="post" class="mzz-jip-form" id="fmUpload"}
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
    <span class="buttons">{form->submit name="submit" id="fmUploadSubmit" value="Загрузить"} {form->reset jip=true name="reset" value="_ simple/cancel"}</span>
</form>
{/if}