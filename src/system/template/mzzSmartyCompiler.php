<?php
/**
 * MZZ Content Management System (c)
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 */

class mzzSmartyCompiler extends Smarty_Internal_SmartyTemplateCompiler
{

    public function compileTag($tag, $args, $parameter = array())
    {
        /**
         * inject of mzz i18n part
         */
        if (is_array($args)) {
            foreach ($args as $key => $vals) {
                foreach ($vals as $attr => $val) {
                    //@todo: sometimes $arg is not scalar???
                    if (is_scalar($val) && (strlen($trimmed = trim($val, '"\'')) === strlen($val) - 2) && i18n::isName($trimmed)) {

                        $args[$key][$attr] = '"' . smarty_prefilter_i18n('{' . $trimmed . '}', $this->template, $this->template->source->resource) . '"';
                    }
                }
            }
        }

        /**
         * end of inject
         */


        return parent::compileTag($tag, $args, $parameter);
    }
}