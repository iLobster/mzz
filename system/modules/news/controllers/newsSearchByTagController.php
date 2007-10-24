<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 1790 2007-06-07 09:48:45Z mz $
 */

/**
 * newsSearchByTagController: ���������� ��� ������ searchByTag ������ news
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
        // ���������� ��� IE ������� ����
        if(strpos($ua, 'MSIE')) {
            $tag = iconv('UTF-8', 'CP1251', $tag);
        }
        //@todo ������� ��� �����

        // �������� ��� obj_id � ������� ���� ���� ���
        $obj_ids =  $tagsMapper->searchObjIdByTag($tag);


        // �������1 ����� � ������������ �������, ������� � ������. �������� ��� ����������� ������.
        // ���� ������ � ������ � ������� ��������� �������� � ���������� obj_id
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

        // ��������� ������� ���� ���� ��������
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

        // �������2 �����. ���� ����� ��������������� ��������� � ������� ���� ������ ����
        // ��������� �������������, ������ ��������, ����� ������ �������


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