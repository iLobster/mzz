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
 * folderEditForm: ����� ��� ������ editFolder ������ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */
class folderEditForm
{
    /**
     * ����� ��������� �����
     *
     * @return object ��������������� �����
     */
    static function getForm($folder, $folderMapper, $action)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withAnyParam');
        $url->setAction($action);
        $url->addParam('name', $folder->getPath());
        $form = new HTML_QuickForm('editFolder', 'POST', $url->get());

        if ($action == 'editFolder') {
            $defaultValues = array();
            $defaultValues['name']  = $folder->getName();
            $defaultValues['title']  = $folder->getTitle();
            $defaultValues['exts'] = $folder->getExts();
            $defaultValues['filesize'] = $folder->getFilesize();
            $form->setDefaults($defaultValues);

            $form->registerRule('isUniqueName', 'callback', 'editFolderValidate');
        } else {
            $form->registerRule('isUniqueName', 'callback', 'editFolderValidate');
        }

        $form->addElement('text', 'name', '���:', 'size="30"');
        $form->addElement('text', 'title', '���������:', 'size="30"');
        $form->addElement('text', 'filesize', '������������ ������ ����� (� ��):', 'size="30"');
        $form->addElement('text', 'exts', '������ ����������� ���������� (���������� ������ ";"):', 'size="30"');

        $form->addRule('filesize', '������ ������ ���� ��������', 'numeric');
        $form->addRule('exts', '������������ ������� � ����������', 'regex', '/^[a-z�-�0-9_;\-\.! ]+$/i');
        $form->addRule('name', '������������ ������� � �����', 'regex', '/^[a-z�-�0-9_\.\-! ]+$/i');
        $form->addRule('name', '��� ������ ���� ��������� � �������� ��������', 'isUniqueName', array($folder, $folderMapper));

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

function editFolderValidate($name, $data)
{
    $path = $data[0]->getPath();
    if ($slash = strpos($path, '/')) {
        $path = substr($path, 0, $slash);
    }
    return $data[0]->getName() == $name || is_null($data[1]->searchByPath($path . '/' . $name));
}

?>