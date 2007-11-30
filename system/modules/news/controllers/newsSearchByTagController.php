<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/news/controllers/newsSearchByTagController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: newsSearchByTagController.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * newsSearchByTagController: контроллер для метода searchByTag модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsSearchByTagController extends simpleController
{
    public function getView()
    {
        $tagsItemMapper = $this->toolkit->getMapper('tags', 'tagsItem', 'tags');
        $tagsMapper = $this->toolkit->getMapper('tags', 'tags', 'tags');

        $section = $this->request->getRequestedSection();
        $tag = $this->request->get('tag', 'string', SC_PATH);
        $db = DB::factory();

        $tag = urldecode($tag);
        $ua = $this->request->get('HTTP_USER_AGENT', 'string', SC_SERVER);
        // декодируем для IE русские таги
        if(strpos($ua, 'MSIE')) {
            $tag = iconv('UTF-8', 'CP1251', $tag);
        }
        //@todo вариант для Оперы

        // выбираем все obj_id у которых есть этот таг
        $obj_ids =  $tagsMapper->searchObjIdByTag($tag);


        // ВАРИАНТ1 Поиск с определением классов, модулей и секций. Подходит для глобального поиска.
        // ищем классы и модули в которых находятся сущности с найденными obj_id
        /*$criteria = new criteria('tags_tagsItem', 'ti');

        $joinRegistry = new criterion('r.obj_id','ti.item_obj_id', criteria::EQUAL, true);
        $criteria->addJoin('sys_access_registry', $joinRegistry, 'r', criteria::JOIN_INNER);

        $joinClassSection = new criterion('r.class_section_id','cs.id', criteria::EQUAL, true);
        $criteria->addJoin('sys_classes_sections', $joinClassSection, 'cs', criteria::JOIN_INNER);

        $joinSection = new criterion('cs.section_id','s.id', criteria::EQUAL, true);
        $criteria->addJoin('sys_sections', $joinSection, 's', criteria::JOIN_INNER);

        $joinClasses = new criterion('cs.class_id','c.id', criteria::EQUAL, true);
        $criteria->addJoin('sys_classes', $joinClasses, 'c', criteria::JOIN_INNER);

        $joinModules = new criterion('c.module_id','m.id', criteria::EQUAL, true);
        $criteria->addJoin('sys_modules', $joinModules, 'm', criteria::JOIN_INNER);

        $objIdCriterion = new criterion('item_obj_id', $obj_ids, criteria::IN);
        $criteria->add($objIdCriterion);

        $criteria->setDistinct();

        $criteria->addSelectField('c.name', 'class');
        $criteria->addSelectField('m.name', 'module');
        $criteria->addSelectField('s.name', 'section');

        $s = new simpleSelect($criteria);
        //echo "<pre>";var_dump($s->toString());echo "</pre>";

        // определив мапперы ищем сами сущности
        $db = DB::factory();
        $neededMappersInfo = $db->getAll($s->toString(), PDO::FETCH_ASSOC);

        $searchCriteria = new criteria();
        $searchCriteria->add(new criterion('obj_id', $obj_ids, criteria::IN));

        $items = array();
        foreach ($neededMappersInfo as $i) {
            //echo "<pre>";var_dump($i);echo "</pre>";
            $mappers[] = $mapper = $this->toolkit->getMapper($i['module'], $i['class'], $i['section']);
            $items = array_merge($items, $mapper->searchAllByCriteria($searchCriteria));
        }*/

        //$this->smarty->assign('news', $items);
        //return $this->smarty->fetch('news/tagged.tpl');

        // ВАРИАНТ2 Поиск. Есть набор идентификаторов элементов у которых есть данные таги
        // пользуясь уникальностью, просто выбираем, через нужные мапперы


        $newsMapper = $this->toolkit->getMapper('news', 'news', 'news');

        $criteria = new criteria();
        $criterion = new criterion('obj_id', $obj_ids, criteria::IN);
        $criteria->add($criterion);

        $items = $newsMapper->searchAllByCriteria($criteria);


        $this->smarty->assign('news', $items);
        return $this->smarty->fetch('news/tagged.tpl');
    }
}

?>