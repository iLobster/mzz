<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('faq/faqCategory');

/**
 * faqCategoryMapper: маппер
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqCategoryMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'faq';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'faqCategory';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function getAnswers($id)
    {
        $faqMapper = systemToolkit::getInstance()->getMapper('faq', 'faq');
        return $faqMapper->searchAllByField('category_id', $id);
    }

    public function delete(faqCategory $do)
    {
        $faqMapper = systemToolkit::getInstance()->getMapper('faq', 'faq');
        foreach ($do->getAnswers() as $faq) {
            $faqMapper->delete($faq->getId());
        }
        parent::delete($do->getId());
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        $do = $this->searchByName($args['name']);

        if ($do) {
            return $do;
        }

        throw new mzzDONotFoundException();
    }
}

?>