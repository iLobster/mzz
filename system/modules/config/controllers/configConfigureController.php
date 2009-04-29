<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * configConfigureController: контроллер для метода configure модуля config
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

class configConfigureController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->getString('name');
        $configFolderMapper = $this->toolkit->getMapper('config', 'configFolder');
        $configOptionMapper = $this->toolkit->getMapper('config', 'configOption');

        $configFolder = $configFolderMapper->searchByName($name);
        if (!$configFolder) {
            return $this->forward404($configFolderMapper);
        }

        $options = $configFolder->getOptions();

        $validator = new formValidator();
        foreach ($options as $option) {
            $validator->add('required', $option->getName(), 'Укажите значение для ' . $option->getTitle());

            switch ($option->getType()) {
                case configOption::TYPE_INT:
                    $validator->add('numeric', $option->getName(), 'Только числовые значения для ' . $option->getTitle());
                    break;
            }
        }

        if ($validator->validate()) {
            foreach ($options as $option) {
                switch ($option->getType()) {
                    case configOption::TYPE_INT:
                        $value = $this->request->getInteger($option->getName(), SC_POST);
                        break;

                    default:
                        $value = $this->request->getString($option->getName(), SC_POST);
                        break;
                }

                if ($value != $option->getValue()) {
                    $option->setValue($value);
                    $configOptionMapper->save($option);
                }
            }

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction('configure');
        $url->add('name', $name);

        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('folder', $configFolder);
        $this->smarty->assign('options', $options);
        return $this->smarty->fetch('config/configure.tpl');
    }
}

?>