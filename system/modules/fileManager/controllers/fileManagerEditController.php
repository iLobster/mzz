<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

fileLoader::load('forms/validators/formValidator');

/**
 * fileManagerEditController: ���������� ��� ������ edit ������ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */

class fileManagerEditController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->get('name', 'string', SC_PATH);

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return $fileMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'name', '������������ ��� ���������� ����');
        $validator->add('regex', 'name', '������������ ������� � �����', '/^[a-z�-�0-9_\.\-! ]+$/i');
        $validator->add('callback', 'name', '��� ������ ���� ��������� � �������� ��������', array('checkFilename', $file));

        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);
            $about = $this->request->get('about', 'string', SC_POST);
            $header = $this->request->get('header', 'string', SC_POST);
            $file->setName($name);
            $file->setAbout($about);
            $file->setRightHeader($header);
            $fileMapper->save($file);

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction('edit');
        $url->add('name', $file->getFullPath());
        $this->smarty->assign('form_action', $url->get());

        $this->smarty->assign('errors', $validator->getErrors());

        $this->smarty->assign('file', $file);
        return $this->smarty->fetch('fileManager/edit.tpl');
    }
}

function checkFilename($name, $file)
{
    if (strtolower($name) == strtolower($file->getName())) {
        return true;
    }

    $criteria = new criteria();
    $criteria->add('folder_id', $file->getFolder()->getId())->add('name', $name);

    $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file');
    return is_null($fileMapper->searchOneByCriteria($criteria));
}

?>