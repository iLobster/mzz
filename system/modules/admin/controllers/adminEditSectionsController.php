<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('codegenerator/fileGenerator');
fileLoader::load('codegenerator/fileSearchReplaceTransformer');

/**
 * adminEditSectionsController
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminEditSectionsController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $sections = $this->toolkit->getSectionsList();
        $modules = $adminMapper->getModules();

        $validator = new formValidator();

        $validator->add('callback', 'array:section', 'неуникальны', array(array($this, 'unique')));
        $validator->add('callback', 'array:section', 'символы', array(array($this, 'chars')));

        if ($validator->validate()) {
            $data = $this->request->getArray('section', SC_POST);

            $data = array_filter($data);
            $data = array_flip($data);

            $str = "<?php\r\n\r\n\$modules = " . var_export($data, true) . ";\r\n\r\n?>";

            try {
                $filegenerator = new fileGenerator(dirname(fileLoader::resolve('configs/modules')));
                $filegenerator->edit('modules.php', new fileSearchReplaceTransformer(null, $str));

                $filegenerator->run();
            } catch (Exception $e) {
                return $e;
            }

            return jipTools::redirect();
        }

        $url = new url('default2');
        $url->setAction($this->request->getAction());

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('sections', array_flip($sections));
        $this->smarty->assign('modules', $modules);
        $this->smarty->assign('errors', $validator->getErrors());

        return $this->smarty->fetch('admin/editSections.tpl');
    }

    public function unique($sections)
    {
        $sections = array_filter($sections);
        return sizeof(array_unique($sections)) == sizeof($sections);
    }

    public function chars($sections)
    {
        $sections = array_filter($sections);

        foreach (array_values($sections) as $val) {
            if (!preg_match('#^[a-z0-9_-]+$#i', $val)) {
                return false;
            }
        }

        return true;
    }
}

?>