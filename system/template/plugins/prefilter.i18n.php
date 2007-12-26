<?php

fileLoader::load('i18n');

function smarty_prefilter_i18n($tpl_source, &$smartyCompiler = null)
{
    static $callback = 'i18n::getMessage';
    static $generatorCallback = 'mzz_smarty_i18n_morph';

    static $lang;
    if (empty($lang)) {
        $lang = systemToolkit::getInstance()->getLocale()->getName();
    }

    if (is_array($tpl_source)) {
        $callback = $tpl_source['callback'];
        return;
    }

    if (is_null($smartyCompiler)) {
        $smartyCompiler = systemToolkit::getInstance()->getSmarty();
    }

    if ($smartyCompiler instanceof mzzSmarty) {
        $tmp = end($smartyCompiler->_smarty_debug_info);
        $file = $tmp['filename'];
    } else {
        // определяем какому модулю принадлежит шаблон
        $file = $smartyCompiler->_current_file;
    }

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

        $replacement[$key] = "\$this->_tpl_vars[\"" . $val . "\"]" . $method;
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