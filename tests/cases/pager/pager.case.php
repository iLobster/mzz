<?php

fileLoader::load('pager');

class pagerTest extends unitTestCase
{
    function setUp()
    {

    }

    function tearDown()
    {

    }

    function testPagerMiddle()
    {
        $pager = new pager($baseurl = '/foo', $page = 5, $items_per_page = 10, 2);
        $pager->setCount($items_count = 98);

        $url = $baseurl . '?page=';

        $result = $pager->toArray();

        $this->assertEqual(array('page' => 1, 'url' => $url . '1'), $result[1]);
        $this->assertEqual(array('skip' => true), $result[2]);
        for ($i = 3; $i <= 7; $i++) {
            $this->assertEqual($i, $result[$i]['page']);
            $this->assertEqual($url . $i, $result[$i]['url']);
        }
        $this->assertEqual(true, $result[5]['current']);
        $this->assertEqual(array('skip' => true), $result[8]);
        $this->assertEqual(array('page' => 10, 'url' => $url . '10'), $result[10]);
        $this->assertEqual($pager->getPage(), $page);
        $this->assertEqual($pager->getPagesTotal(), ceil($items_count / $items_per_page));
        $this->assertEqual($pager->getPerPage(), $items_per_page);
    }

    function testPagerLeft()
    {
        $pager = new pager($baseurl = '/foo', $page = 2, $items_per_page = 10, 2);
        $pager->setCount($items_count = 98);

        $url = $baseurl . '?page=';

        $result = $pager->toArray();

        $this->assertEqual(array('page' => 1, 'url' => $url . '1'), $result[1]);
        for ($i = 2; $i <= 4; $i++) {
            $this->assertEqual($i, $result[$i]['page']);
            $this->assertEqual($url . $i, $result[$i]['url']);
        }
        $this->assertEqual(true, $result[2]['current']);
        $this->assertEqual(array('skip' => true), $result[5]);
        $this->assertEqual(array('page' => 10, 'url' => $url . '10'), $result[10]);
    }

    function testPagerRight()
    {
        $pager = new pager($baseurl = '/foo', $page = 9, $items_per_page = 10, 2);
        $pager->setCount($items_count = 98);

        $url = $baseurl . '?page=';

        $result = $pager->toArray();

        $this->assertEqual(array('page' => 1, 'url' => $url . '1'), $result[1]);
        $this->assertEqual(array('skip' => true), $result[2]);
        for ($i = 7; $i <= 10; $i++) {
            $this->assertEqual($i, $result[$i]['page']);
            $this->assertEqual($url . $i, $result[$i]['url']);
        }
        $this->assertEqual(true, $result[9]['current']);
    }

    public function testGetLimitQuery()
    {
        $pager = new pager($baseurl = '/foo', $page = 5, $items_per_page = 10, 2);
        $pager->setCount($items_count = 98);
        $criteria = $pager->getLimitQuery();

        $this->assertIsA($criteria, 'criteria');
        $this->assertEqual($criteria->getLimit(), 10);
        $this->assertEqual($criteria->getOffset(), 40);
    }
}

?>