<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/user/controllers/userLoginController.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userLoginController.php 4202 2010-04-12 13:48:43Z desperado $
 */

/**
 * aPamProvider: abstract class
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
abstract class aPamProvider implements iPamProvider
{
    protected $toolkit;
    protected $view;
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->view = $this->toolkit->getView();
        $this->request = $this->toolkit->getRequest();
        $this->response = $this->toolkit->getResponse();
    }

    public function validate(validator &$validator){}

    public function logout(user $user = null, & $backUrl = null) {}

    public function delete(user $user){}
}