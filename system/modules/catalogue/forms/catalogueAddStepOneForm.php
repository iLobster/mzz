<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/catalogue/forms/catalogueAddStepOneForm.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueAddStepOneForm.php 1365 2007-03-02 21:11:37Z mz $
 */

/**
 * catalogueAddStepOneForm: ����� ��� ������ save ������ page
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
class catalogueAddStepOneForm
{
    /**
     * ����� ��������� �����
     *
     * @param string $action ������� ��������
     * @param array $properties ��������
     * @param array $type ������ �������� ����
     * @return object ��������������� �����
     */
    static function getForm( Array $types )
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('default2');
        $url->setAction('add');
        $url->setSection('catalogue');

        $form = new HTML_QuickForm('frmAddStepOne', 'POST', $url->get());

        $selectTypes = array();
        foreach ($types as $type) {
            $selectTypes[$type['id']] = $type['title'];
        }

        $form->addElement('select', 'type', '���', $selectTypes);

        $form->addElement('reset', 'reset', '������','onclick=\'javascript: jipWindow.close();\'');
        $form->addElement('submit', 'submit', '����� >');
        return $form;
    }
}
?>