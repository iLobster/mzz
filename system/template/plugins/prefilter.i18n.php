<?php

function smarty_prefilter_i18n($tpl_source,&$smarty)
{
    static $lang;
    if (empty($lang)) {
        $lang = systemToolkit::getInstance()->getLocale()->getName();
    }

    return preg_replace('~\{_\s+(.*?)\}~e','lang_getmessage("$1", "' . $lang . '")',$tpl_source);
}

function lang_getmessage($arg, $lang)
{
    return $arg . ' (' . $lang . ')';
}

?>