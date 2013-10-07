<?php

function smarty_prefilter_i18n($tpl_source, Smarty_Internal_Template $template, $resource = false)
{
    static $callback = 'i18n::getMessage';
    static $generatorCallback = 'mzz_smarty_i18n_morph';

    static $lang;
    if (empty($lang) && systemConfig::$i18nEnable) {
        $lang = systemToolkit::getInstance()->getLocale()->getName();
    }

    if (is_array($tpl_source)) {
        $callback = $tpl_source['callback'];
        return;
    }

    $file = (!empty($resource)) ? $resource : $template->source->resource;

    if (strpos($file, 'act/') === 0) {
        $module = substr($file, 4, strpos($file, '/', 4) - 4);
    } elseif (($slashpos = strpos($file, '/')) !== false) {
        $module = substr($file, 0, $slashpos);
    } else {
        $module = 'simple';
    }

    return preg_replace('#\{_\s+(\'|"|)(.*?)(?:\\1)(?:\s+(.*?))?\}#e', $callback . "('$2', '" . $module . "', '" . $lang . "', '$3', '" . $generatorCallback . "')", $tpl_source);
}

function mzz_smarty_i18n_morph($phrase, $variables, $lang)
{
    $replacement = array();

    foreach ($variables as $key => $val) {
        $method = '';
        if (($arrowpos = strpos($val, '->')) !== false) {
            $method = substr($val, $arrowpos);
            $val = substr($val, 0, $arrowpos);
        }

        if (strpos($val, '$') === 0) {
            $val = substr($val, 1);
        }

        if (strpos($val, '"') === 0) {
            $replacement[$key] = $val;
        } else {

            $replacement[$key] = '$_smarty_tpl->tpl_vars[\'' . $val . '\']->value' . $method;
        }
    }

    if (!is_array($phrase)) {
        $phrase = array($phrase);
    }

    $result = '{php}$i18n = new i18n(); ';
    $result .= '$arg = ' . reset($replacement) . '; $morphs = ' . var_export($phrase, true) . '; ';
    $result .= '$morph = $i18n->morph($arg, $morphs, \'' . $lang . '\'); echo $i18n->replacePlaceholders($morph, array(' . implode(", ", $replacement) . '));';
    $result .= '{/php}';

    return $result;
}

?>