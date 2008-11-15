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

fileLoader::load('forms/validators/formHostnameRule');

/**
 * formUrlRule: правило, проверяющее правильность URL
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formUrlRule extends formHostnameRule
{
    public function validate()
    {
        if (empty($this->value)) {
            return true;
        }
        $pattern = '#^((https?|ftps?)://)?(?<domain>[-A-Z0-9.]+)(:[0-9]{2,4})?(/[-A-Z0-9+&@\#/%=~_|!:,.;]*)?(\?[-A-Z0-9+&@\#/%=~_|!:,.;]*)?$#i';

        if(!preg_match($pattern, $this->value, $matches)) {
            return false;
        }

        $this->value = $matches['domain'];
        return parent::validate();
    }
}

?>