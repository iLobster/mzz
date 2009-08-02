<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Офис администратора {title separator=" | " start=" - "}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="generator" content="{$smarty.const.MZZ_NAME} v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION}" />
    <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/templates/css/admin/admin.css" />
    <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/templates/css/admin/system.css" />
    <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/templates/css/icons.css" />
    <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/templates/css/bullets.css" />
    <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/templates/css/flags.css" />
    {include file='include.css.tpl'}
    <script type="text/javascript">
    //<!--
        var SITE_PATH = '{$SITE_PATH}';
        var SITE_LANG = '{$current_lang}';
        var tinyMCEPreInit = {ldelim}suffix: '', base : SITE_PATH + '/templates/js/tiny_mce'{rdelim};
    //-->
    </script>
    {include file='include.external.js.tpl'}
</head>
<body>
{$content}
</body>
</html>