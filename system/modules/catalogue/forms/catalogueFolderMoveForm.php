<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/forms/catalogueFolderMoveForm.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueFolderMoveForm.php 657 2007-03-05 21:47:20Z zerkms $
 */

/**
 * catalogueFolderMoveForm: ����� ��� ������ moveFolder ������ catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueFolderMoveForm
{
    /**
     * ����� ��������� �����
     *
     * @param object $folder
     * @param array $folders
     * @return object ��������������� �����
     */
    static function getForm($folder, $folders)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withAnyParam');
        $url->setAction('moveFolder');
        $url->addParam('name', $folder->getPath());
        $form = new HTML_QuickForm('folderMove', 'POST', $url->get());

        $defaultValues = array();
        if ($parent = $folder->getTreeParent()) {
            $defaultValues['dest']  = $parent->getParent();
        }
        $form->setDefaults($defaultValues);

        $dests = array();
        foreach ($folders as $key => $val) {
            $dests[$key] = $val->getPath();
        }

        $select = $form->addElement('select', 'dest', '������� ����������', $dests);
        $select->setSize(5);

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>