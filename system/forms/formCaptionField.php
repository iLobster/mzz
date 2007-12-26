<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * formCaptionField: заголовок поля формы
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCaptionField extends formElement
{
    static public function toString($options = array())
    {
        if (i18n::isName($options['value'])) {
            $options['value'] = smarty_prefilter_i18n('{' . $options['value'] . '}');
        }

        $result = $options['value'];
        $required = '';

        if (self::isRequired($options)) {
            $required = (isset($options['onRequired']) ? $options['onRequired'] : '<span style="color: red;">*</span> ');
            unset($options['onRequired']);
        }

        if (!array_key_exists('onError', $options)) {
            $options['onError'] = 'style=color: red;';
        }

        if (self::parseError($options)) {
            $options['content'] = $result;
            unset($options['value']);
            unset($options['name']);

            $result = self::createTag($options, 'span');
        }

        return $required . $result;
    }
}

?>