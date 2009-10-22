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

/**
 * fileManagerEditController: контроллер для метода edit модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */
class fileManagerEditController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->getString('name');

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return $this->forward404($folderMapper);
        }

        $validator = new formValidator();
        $validator->rule('required', 'name', 'Обязательное для заполнения поле');
        $validator->rule('regex', 'name', 'Недопустимые символы в имени', '/^[a-zа-я0-9_\.\-! ]+$/ui');
        $validator->rule('callback', 'name', 'Имя должно быть уникально в пределах каталога', array(array($this, 'checkFilename'), $file));

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $about = $this->request->getString('about', SC_POST);
            $header = $this->request->getBoolean('header', SC_POST);
            $direct_link = $this->request->getBoolean('direct_link', SC_POST);

            $file->setName($name);
            $file->setAbout($about);
            $file->setRightHeader($header);
            $file->setDirectLink($direct_link);

            $fileMapper->save($file);

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->add('name', $name);
        $url->setAction('edit');

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('validator', $validator);
        $this->smarty->assign('file', $file);
        return $this->smarty->fetch('fileManager/edit.tpl');
    }

    public function checkFilename($name, $file)
    {
        if (strtolower($name) == strtolower($file->getName())) {
            return true;
        }

        $criteria = new criteria();
        $criteria->where('folder_id', $file->getFolder()->getId())->add('name', $name);

        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file');
        return is_null($fileMapper->searchOneByCriteria($criteria));
    }
}

?>