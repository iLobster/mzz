<div class="jipTitle">
{if $isEdit}Редактирование страницы "{$page->getName()|h}"{else}Создание страницы{/if}
</div>

{literal}<script type="text/javascript">

fileLoader.loadJS(SITE_PATH + '/js/tiny_mce/jquery.tinymce.js');

(function($) {
    toggleEditor = function(id) {
        //console.log($.isUndefined(tinyMCE));
        if (!(tinyMCE) || tinyMCE.getInstanceById(id) == null) {
            $('#' + id).tinymce({
                script_url: SITE_PATH + '/js/tiny_mce/tiny_mce_jquery.js',
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
                add_form_submit_trigger: false
            });

            jipWindow.addTinyMCEId(id);
            $('#' + id + '_editorStatus').text('Выключить WYSIWYG-редактор');
        } else {
            tinyMCE.execCommand('mceRemoveControl', false, id);
            jipWindow.deleteTinyMCEId(id);
            $('#' + id + '_editorStatus').text('Включить WYSIWYG-редактор');
        }
    }
})(jQuery);

</script>{/literal}
{form action=$form_action method="post" onsubmit="if (tinyMCE) tinyMCE.triggerSave(true, true); return jipWindow.sendForm(this);"}
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
        <td style='width: 15%;'>{form->caption name="page[name]" value="Идентификатор"}</td>
        <td style='width: 85%;'>{form->text name="page[name]" value=$page->getName() size="60"}{$validator->getFieldError('page[name]')}</td>
    </tr>
    <tr>
        <td style='width: 15%;'>{form->caption name="page[title]" value="Название"}</td>
        <td style='width: 85%;'>{form->text name="page[title]" value=$page->getTitle() size="60"}</td>
    </tr>
    <tr>
        <td style='width: 15%;'>{form->caption name="page[compiled]" value="Компилируемая"}</td>
        <td style='width: 85%;'>{form->checkbox name="page[compiled]" value=$page->getCompiled()}</td>
    </tr>
    <tr>
        <td style='width: 15%;'>{form->caption name="page[keywords]" value="Ключевые слова"}</td>
        <td style='width: 85%;'>{form->text name="page[keywords]" value=$page->getKeywords() size="60"}&nbsp;{form->select name="page[keywordsReset]" options="options добавить|заменить" value=$page->isKeywordsReset()}</td>
    </tr>
    <tr>
        <td style='width: 15%;'>{form->caption name="page[description]" value="Описание"}</td>
        <td style='width: 85%;'>{form->text name="page[description]" value=$page->getDescription() size="60"}&nbsp;{form->select name="page[descriptionReset]" options="options добавить|заменить" value=$page->isDescriptionReset()}</td>
    </tr>
    <tr>
        <td style='width: 15%;'>{form->caption name="page[allow_comment]" value="Разрешить комментарии?"}</td>
        <td style='width: 85%;'>{form->checkbox name="page[allow_comment]" value=$page->getAllowComment()}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="font-size: 80%;"><a href="javascript: toggleEditor('contentArea');" id="contentArea_editorStatus" style="text-decoration: none; border-bottom: 1px dashed #aaa;">Включить WYSIWYG-редактор</a></td>
    </tr>
    <tr>
        <td style='vertical-align: top;'>{form->caption name="page[content]" value="Содержимое"}</td>
        <td>{form->textarea name="page[content]" value=$page->getContent() rows="20" style="width: 100%;" id="contentArea" cols="50"}{$validator->getFieldError('page[content]')}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
    </tr>
</table>
</form>
