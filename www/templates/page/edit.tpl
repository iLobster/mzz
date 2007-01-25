{add file="tiny_mce/tiny_mce_src.js"}

{if $action eq 'edit'}
{include file='jipTitle.tpl' title='Редактирование страницы'}
{else}
{include file='jipTitle.tpl' title='Создание страницы'}
{/if}

<form {$form.attributes} onsubmit="if (tinyMCE) tinyMCE.triggerSave(true, true); return sendFormWithAjax(this);return false;">
{$form.hidden}
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td style='width: 15%;'>{$form.name.label}</td>
        <td style='width: 85%;'>{$form.name.html}</td>
    </tr>
    <tr>
        <td>{$form.title.label}</td>
        <td>{$form.title.html}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>{$form.content.html}</td>
    </tr>
    <tr>
        <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
    </tr>
</table>
</form>

{javascript}{literal}
    tinyMCE.init({
        theme : "advanced",
        mode : "exact",
        elements : "content",
        plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
        theme_advanced_buttons1_add_before : "save,newdocument,separator",
        theme_advanced_buttons1_add : "fontselect,fontsizeselect",
        theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor,advsearchreplace",
        theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
        theme_advanced_buttons3_add_before : "tablecontrols,separator",
        theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_path_location : "bottom",
        plugin_insertdate_dateFormat : "%Y-%m-%d",
        plugin_insertdate_timeFormat : "%H:%M:%S",
        extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
        external_link_list_url : "example_link_list.js",
        external_image_list_url : "example_image_list.js",
        flash_external_list_url : "example_flash_list.js",
        media_external_list_url : "example_media_list.js",
        theme_advanced_resize_horizontal : false,
        theme_advanced_resizing : true,
        nonbreaking_force_tab : true,
        apply_source_formatting : true
    });
{/literal}{/javascript}