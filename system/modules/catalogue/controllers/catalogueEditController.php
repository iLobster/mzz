<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/catalogue/controllers/catalogueEditController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueEditController.php 1368 2007-03-03 00:19:30Z mz $
 */

fileLoader::load('catalogue/forms/catalogueObjectForm');

/**
 * catalogueEditController: контроллер для метода edit модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueEditController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $objectId = $this->request->get('id', 'integer', SC_PATH);

        $catalogue = $catalogueMapper->searchById($objectId);

        $properties = $catalogueMapper->getProperties($catalogue->getType());

        $form = catalogueObjectForm::getForm($catalogue, $properties);

        if ($form->validate() == false){
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $renderer->setRequiredTemplate('{if $error}<font color="red"><strong>{$label}</strong></font>{else}{if $required}<span style="color: red;">*</span> {/if}{$label}{/if}');
            $renderer->setErrorTemplate('{if $error}<div class="formErrorElement">{$html}</div><font color="gray" size="1">{$error}</font>{else}{$html}{/if}');
            $form->accept($renderer);

            $this->smarty->assign('fields', array_keys($catalogue->exportOldProperties()));
            $this->smarty->assign('form', $renderer->toArray());
            return $this->smarty->fetch('catalogue/object.tpl');
        } else {
            $values = $form->exportValues();

            foreach(array_keys($catalogue->exportOldProperties()) as $property){
                $catalogue->setProperty($property, $values[$property]);
            }

            $catalogueMapper->save($catalogue);
            return jipTools::redirect();
        }
    }
}

?>