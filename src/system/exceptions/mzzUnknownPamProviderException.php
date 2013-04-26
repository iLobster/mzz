<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/exceptions/mzzUnknownMailBackendException.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage exceptions
 * @version $Id: mzzUnknownMailBackendException.php 3604 2009-08-12 06:46:57Z striker $
*/

/**
 * mzzUnknownMailBackendException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/

class mzzUnknownPamProviderException extends mzzException
{
    public function __construct($provider)
    {
        $message = "PAM Provider '" . $provider . "' not found";
        parent::__construct($message);
    }
}

?>
