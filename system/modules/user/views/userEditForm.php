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
 * userEditForm: форма для метода edit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userEditForm
{
    /**
     * метод получения формы
     *
     * @param object $user редактируемый пользователь
     * @param string $section текущая секция
     * @param string $action текущее действие
     * @param object $userMapper
     * @return object сгенерированная форма
     */
    static function getForm($user, $section, $action, $userMapper)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $formAction = '/' . $section . ($action == 'edit' ? '/' . $user->getId() : '') . '/' . $action;
        $form = new HTML_QuickForm('userEdit', 'POST', $formAction);

        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['login']  = $user->getLogin();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'login', 'Логин:', 'size=30');
        $form->addElement('password', 'password', 'Пароль:', 'size=30');

        $form->registerRule('isUniqueLogin', 'callback', 'createUserValidation');
        $form->addRule('login', 'пользователь с таким именем уже существует', 'isUniqueLogin', array($user, $userMapper));

        $form->addElement('reset', 'reset', 'Отмена','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}

function createUserValidation($login, $data)
{
    if ($login !== $data[0]->getLogin()) {
        $user = $data[1]->searchByLogin($login);

        if ($user->getId() != MZZ_USER_GUEST_ID) {
            return false;
        }
    }
    return true;
}

?>