<?php

fileLoader::load('i18n');

function smarty_prefilter_i18n($tpl_source, &$smartyCompiler)
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

    // определяем какому модулю принадлежит шаблон
    $file = $smartyCompiler->_current_file;
    if (strpos($file, 'act/') === 0) {
        $module = substr($file, 4, strpos($file, '/', 4) - 4);
    } elseif (($slashpos = strpos($file, '/')) !== false) {
        $module = substr($file, 0, $slashpos);
    } else {
        $module = 'simple';
    }

    return preg_replace('#\{_\s+(\'|"|)(.*?)(?:\\1)(?:\s+(.*?))?\}#e', $callback . "('$2', '" . $module . "', '" . $lang . "', '$3', '" . $generatorCallback . "')", $tpl_source);
}

function mzz_smarty_i18n_morph($phrase, $variables)
{
    $replacement = array();
    foreach ($variables as $key => $val) {
        $replacement[$key] = "\$this->_tpl_vars[\"" . $val . "\"]";
    }

    return '{php}$i18n = new i18n(); echo $i18n->replacePlaceholders(\'' . $phrase . '\', ' . implode(" . ' ' . ", $replacement) . '); {/php}';
}

?>