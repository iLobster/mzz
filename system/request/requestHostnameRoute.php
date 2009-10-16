<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/request/requestRoute.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id: requestRoute.php 3366 2009-06-18 01:04:27Z zerkms $
*/

fileLoader::load('request/requestRoute');

/**
 * requestHostnameRoute: правило для маршрутизатора хостнейма.
 *
 * @package system
 * @subpackage request
 * @version 0.1
 */
class requestHostnameRoute extends requestRoute
{
    protected $part_delimiter = '.';

    protected $default_regex = '[^.]';

    protected $hostRoute = true;

    protected $request;

    public function setRequest(iRequest $request)
    {
        $this->request = $request;
    }

    public function match($path, $debug = false)
    {
        $path = $this->getRequest()->getHttpHost();
        return parent::match($path, $debug);
    }

    public function getRequest()
    {
        if ($this->request == null) {
            return systemToolkit::getInstance()->getRequest();
        }

        return $this->request;
    }

    /**
     * Собирает из массива параметров URL согласно данному Route
     *
     * @param array $values массив именованных параметров
     * @return string готовый URL
     */
    public function assemble($values = array())
    {
        if (isset($values['scheme'])) {
            $scheme = $values['scheme'];
        } else {
            $scheme = $this->getRequest()->getScheme();
        }
        return $scheme . '://' . parent::assemble($values);
    }
}

?>
