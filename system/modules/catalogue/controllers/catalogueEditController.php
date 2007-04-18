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

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать элемент');

        foreach ($catalogue->exportOldProperties() as $property) {
            if ($property['type'] == 'int') {
                $validator->add('numeric', $property['name'], 'Нужен int');
            } elseif ($property['type'] == 'float') {
                $validator->add('numeric', $property['name'], 'Нужен float');
            }
        }

        if (!$validator->validate()) {
            $url = new url('withAnyParam');
            $url->setSection($this->request->getSection());
            $url->setAction('edit');
            $url->addParam('name', $catalogue->getId());

            $this->smarty->assign('catalogue', $catalogue);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());

            return $this->smarty->fetch('catalogue/object.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);
            $catalogue->setName($name);
            foreach($catalogue->exportOldProperties() as $property){
                $propValue = $this->request->get($property['name'], 'mixed', SC_POST);
                $catalogue->setProperty($property['name'], $propValue);
            }

            $catalogueMapper->save($catalogue);
            return jipTools::redirect();
        }
    }
}

?>