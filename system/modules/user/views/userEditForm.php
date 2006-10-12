<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * userEditForm: ����� ��� ������ edit ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userEditForm
{
    /**
     * ����� ��������� �����
     *
     * @param object $user ������������� ������������
     * @param string $section ������� ������
     * @return object ��������������� �����
     */
    static function getForm($user, $section, $action, $userMapper)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $form = new HTML_QuickForm('userEdit', 'POST', '/' . $section . '/' . $user->getId() . '/' . $action);

        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['login']  = $user->getLogin();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('text', 'login', '�����:', 'size=30');

        $form->registerRule('isUniqueLogin', 'callback', 'createUserValidation');
        $form->addRule('login', '������������ � ����� ������ ��� ����������', 'isUniqueLogin', array($user, $userMapper));

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: window.close();\'');
        $form->addElement('submit', 'submit', '���������');
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
