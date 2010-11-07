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
 * simplePamProvider: for default login method
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class simplePamProvider extends aPamProvider
{

    public function login()
    {
        $login = $this->request->getString('login', SC_POST);
        $password = $this->request->getString('password', SC_POST);
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $user = $userMapper->searchByLoginAndPassword($login, $password);
        return $user;
    }

    public function logout(User $user = null)
    {
        
    }

    public function validate(Validator &$validator)
    {
        $validator->rule('required', 'login', 'Login field is required');
        $validator->rule('required', 'password', 'Password field is required');
    }

}

?>