<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 1309 2007-02-13 05:54:09Z zerkms $
 */

fileLoader::load('catalogue/forms/catalogueMoveForm');
 
/**
 * catalogueMoveController: ���������� ��� ������ move ������ catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueMoveController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');

        $catalogue = $catalogueMapper->searchById($id);

        if (!$catalogue) {
            return $catalogueMapper->get404()->run();
        }

        $folders = $catalogueFolderMapper->searchAll();

        $form = catalogueMoveForm::getForm($catalogue, $folders);

        if ($form->validate()) {
            $values = $form->exportValues();

            $destFolder = $catalogueFolderMapper->searchById($values['dest']);

            if (!$destFolder) {
                /* @todo get404() ? */
                return '������� ���������� �� ������';
            }

            $catalogue->setFolder($destFolder);
            $catalogueMapper->save($catalogue);

            return jipTools::redirect();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('news', $catalogue);
        return $this->smarty->fetch('catalogue/move.tpl');
    }
}

?>