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

fileLoader::load('fileManager/views/fileEditForm');

/**
 * fileManagerEditController: контроллер для метода edit модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerEditController extends simpleController
{
    public function getView()
    {
        $name = $this->request->get('name', 'string', SC_PATH);

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return 'файл не найден';
        }

        $form = fileEditForm::getForm($file);

        if ($form->validate()) {
            $values = $form->exportValues();

            $ext = '';
            if (($dot = strrpos($values['name'], '.')) !== false) {
                $ext = substr($values['name'], $dot + 1);
            }

            $file->setName($values['name']);
            $file->setExt($ext);
            $fileMapper->save($file);
            //echo '<br><pre>'; var_dump($values); echo '<br></pre>';
            return 'ok';
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('fileManager/edit.tpl');
    }
}

?>