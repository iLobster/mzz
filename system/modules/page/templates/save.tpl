<div class="jipTitle">
{if $isEdit}Редактирование страницы "{$page->getName()|h}"{else}Создание страницы{/if}
</div>

{literal}<script type="text/javascript">

fileLoader.loadJS(SITE_PATH + '/js/tiny_mce/jquery.tinymce.js');

(function($) {
    toggleEditor = function(id) {
        if (!(tinyMCE) || tinyMCE.getInstanceById(id) == null) {
            $('#' + id).tinymce({
                script_url: SITE_PATH + '/js/tiny_mce/tiny_mce.js',
                theme : "advanced",
                skin : 'o2k7',
                skin_variant : "",
                mode : "none",
                plugins : "inlinepopups,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
                language : "ru",
                theme_advanced_buttons1_add : "fontselect,fontsizeselect",
                theme_advanced_buttons2_add : "separator,forecolor,backcolor,advsearchreplace",
                theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
                theme_advanced_buttons3_add_before : "insertdate,inserttime,preview,separator,tablecontrols,separator",
                theme_advanced_buttons3_add : "emotions,iespell,separator,print",
                theme_advanced_buttons4 : "ltr,rtl,separator,fullscreen,separator,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_path_location : "bottom",
                plugin_insertdate_dateFormat : "%Y-%m-%d",
                plugin_insertdate_timeFormat : "%H:%M:%S",
                extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
                /*external_link_list_url : "example_link_list.js",
                external_image_list_url : "example_image_list.js",
                flash_external_list_url : "example_flash_list.js",
                media_external_list_url : "example_media_list.js",*/
                theme_advanced_resize_horizontal : false,
                theme_advanced_resizing : true,
                nonbreaking_force_tab : true,
                apply_source_formatting : true,
                add_unload_trigger : false,
                add_form_submit_trigger: false,
                relative_urls : false,
                remove_script_host: true,
                file_browser_callback: function (field_name, url, type, win) {
                    tinyMCE.activeEditor.windowManager.open({
                        'file' : '/fileBrowser/browse?tiny_mce=true',
                        'title' : 'mzz file browser',
                        'width' : 700,
                        'height' : 458,
                        'resizable' : "yes",
                        'inline' : "yes",
                        'close_previous' : "no"
                    }, {
                        'window' : win,
                        'input' : field_name,
                        'url': url,
                        'type': type,
                        'jip': jipWindow,
                    });
                    return false;
                },
                oninit : function(){jipWindow.resize()}
            });



            jipWindow.addTinyMCEId(id);
            $('#' + id + '_editorStatus').text('Выключить WYSIWYG-редактор');
        } else {
            tinyMCE.execCommand('mceRemoveControl', false, id);
            jipWindow.deleteTinyMCEId(id);
            $('#' + id + '_editorStatus').text('Включить WYSIWYG-редактор');
            jipWindow.resize();
        }
    }
})(jQuery);

</script>{/literal}
{form action=$form_action method="post" onsubmit="if (tinyMCE) tinyMCE.triggerSave(true, true); return jipWindow.sendForm(this);"}
<div class="field">
    <div class="label">
        {form->caption name="page[name]" value="Идентификатор"}
    </div>
    <div class="text">
        {form->text name="page[name]" value=$page->getName() size="60"}{$validator->getFieldError('page[name]')}
        <span class="caption error"></span>
    </div>
</div>
<div class="field">
    <div class="label">
        {form->caption name="page[title]" value="Название"}
    </div>
    <div class="text">
        {form->text name="page[title]" value=$page->getTitle() size="60"}
        <span class="caption error"></span>
    </div>
</div>
<div class="field">
    <div class="label">
        {form->caption name="page[keywords]" value="Ключевые слова"}
    </div>
    <div class="text">
        {form->text name="page[keywords]" value=$page->getKeywords() style="width: 80%"}&nbsp;{form->select name="page[keywordsReset]" options="options добавить|заменить" value=$page->isKeywordsReset()}
        <span class="caption error"></span>
    </div>
</div>
<div class="field">
    <div class="label">
        {form->caption name="page[description]" value="Описание"}
    </div>
    <div class="text">
        {form->text name="page[description]" value=$page->getDescription() style="width: 80%"}&nbsp;{form->select name="page[descriptionReset]" options="options добавить|заменить" value=$page->isDescriptionReset()}
        <span class="caption error"></span>
    </div>
</div>
<div class="field">
    <div class="text">
        <span class="caption"><a href="javascript: toggleEditor('contentArea');" id="contentArea_editorStatus" style="text-decoration: none; border-bottom: 1px dashed #aaa;">Включить WYSIWYG-редактор</a></span>
    </div>
</div>
<div class="field">
    <div class="label">
        {form->caption name="page[content]" value="Содержимое"}
    </div>
    <div class="text">
        {form->textarea name="page[content]" value=$page->getContent() rows="20" style="width: 90%;" id="contentArea" cols="50"}
        <span class="caption error">{$validator->getFieldError('page[content]')}</span>
    </div>
</div>
<div class="field">
    <div class="label">

    </div>
    <div class="text">
        {form->checkbox name="page[compiled]" value=$page->getCompiled()} {form->caption name="page[compiled]" value="Компилируемая"}
        <span class="caption error"></span>
    </div>
</div>
<div class="field">
    <div class="label">

    </div>
    <div class="text">
        {form->checkbox name="page[allow_comment]" value=$page->getAllowComment()} {form->caption name="page[allow_comment]" value="Разрешить комментарии?"}
        <span class="caption error"></span>
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}
    </div>
</div>
</form>
