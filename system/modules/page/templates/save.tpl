{if $isEdit}
    <div class="jipTitle">Редактирование страницы "{$page->getName()|htmlspecialchars}"</div>
{else}
    <div class="jipTitle">Создание страницы</div>
{/if}

{literal}<script type="text/javascript">
tinyMCE.init({
        theme : "advanced",
        mode : "none",
        plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",

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
        language: 'ru',
        nonbreaking_force_tab : true,
        apply_source_formatting : true,
        add_unload_trigger : false,
        add_form_submit_trigger: false
    });

function toggleEditor(id) {
    var elm = $(id);
    var tinyMCEInterval = false;
    var removeEditorLoadingStatus = function () {
            tinyMCEInterval ? clearInterval(tinyMCEInterval) : false;
            var editorLoadingText = $('editorLoadingText');
            editorLoadingText ? editorLoadingText.parentNode.removeChild(editorLoadingText) : false;
    };

    if (tinyMCE.getInstanceById(id) == null && tinyMCEInterval == false) {
        new Insertion.Before(elm, '<div id="editorLoadingText"><strong>Загрузка редактора...</strong></div>');
        tinyMCEInterval = setInterval(function() {
            if (tinyMCE.loadingIndex == -1) {
                tinyMCE.execCommand('mceAddControl', false, id);
                removeEditorLoadingStatus();
                jipWindow.addTinyMCEId(id);
            }}, 100);
        $('editorStatus').innerHTML = 'Выключить WYSIWYG-редактор';
    } else {
        removeEditorLoadingStatus();
        tinyMCE.execCommand('mceRemoveControl', false, id);
        jipWindow.deleteTinyMCEId(id);
        $('editorStatus').innerHTML = 'Включить WYSIWYG-редактор';
    }
}
</script>{/literal}
<form action="{$form_action}" method="post" onsubmit="if (tinyMCE) tinyMCE.triggerSave(true, true); return jipWindow.sendForm(this);">
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td style='width: 15%;'>{form->caption name="name" value="Идентификатор" onError="style=color: red;"}</td>
        <td style='width: 85%;'>{form->text name="name" value=$page->getName() size="60"}{$errors->get('name')}</td>
    </tr>
    <tr>
        <td style='width: 15%;'>{form->caption name="title" value="Название" onError="style=color: red;"}</td>
        <td style='width: 85%;'>{form->text name="title" value=$page->getTitle() size="60"}</td>
    </tr>
        <tr>
        <td style='width: 15%;'>{form->caption name="title" value="Компилируемая" onError="style=color: red;"}</td>
        <td style='width: 85%;'>{form->checkbox name="compiled" value=$page->getCompiled()}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="font-size: 80%;"><a href="javascript: toggleEditor('contentArea');" id="editorStatus" style="text-decoration: none; border-bottom: 1px dashed #aaa;">Включить WYSIWYG-редактор</a></td>
    </tr>
    <tr>
        <td style='vertical-align: top;'>{form->caption name="contentArea" value="Содержимое" onError="style=color: red;"}</td>
        <td>{form->textarea name="contentArea" value=$page->getContent() rows="4" style="width: 100%;" id="contentArea" cols="50"}{$errors->get('contentArea')}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
    </tr>
</table>
</form>