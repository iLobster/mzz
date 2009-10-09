<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
    <title>{title separator=" | " start=" - "}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/css/style.css" />
    <script type="text/javascript">
    <!--
    var SITE_PATH = '{$SITE_PATH}';
    var SITE_LANG = '{$current_lang}';
    //-->
    </script>
    {include file='include.css.tpl'}
    {include file='include.external.js.tpl'}
</head>
<body>
<div class="separator">&nbsp;</div>
<p />
{$content}
<p />
<div class="separator">&nbsp;</div>
{$timer->toString()}
</body>
</html>