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
 * iPamProvider: interface
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
interface iPamProvider
{

    /**
     * Method for login in user
     *
     * @return user|null - user object on success or null
     */
    public function login();

    /**
     * Clean out some stuff after user logout
     *
     * You may mangle on $backUrl if need in some redirections, but you should not redirect inside
     */
    public function logout(user $user = null, & $backUrl = null);

    /**
     * Add validation rules and do some hidden magic.
     *
     * @return boolean - true on success
     */
    public function validate(validator &$validator);

    /**
     * Validate stored userAuth, basicle used in userFilter
     *
     * @return boolean - true on success
     */
    public function checkAuth(user $user);

    /**
     * Delete user stuff
     *
     */
    public function delete(user $user);
}