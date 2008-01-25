<?php

fileLoader::load('simple/simpleMapper');
fileLoader::load('cases/modules/simple/stubMapper.class');

class simpleMapperi18nTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;
    private $fixture;
    private $fixture_i18n;

    public function __construct()
    {
        $this->map = array(
        'id'  => array ('name' => 'id', 'accessor' => 'getId',  'mutator' => 'setId'),
        'foo' => array ('name' => 'foo','accessor' => 'getFoo', 'mutator' => 'setFoo', 'lang' => true),
        'bar' => array ('name' => 'bar','accessor' => 'getBar', 'mutator' => 'setBar'),
        'obj_id' => array ('name' => 'obj_id','accessor' => 'getObjId', 'mutator' => 'setObjId'),
        );

        $this->fixture = array(1 => array('foo'=>'foo1','bar'=>'bar1'),
        2 => array('foo'=>'foo2','bar'=>'bar2'),
        3 => array('foo'=>'foo3','bar'=>'bar3'));

        $this->fixture_i18n = array(
        '1_1' => array('id' => 1, 'foo'=>'foo_i18n_1_lang_1', 'lang_id' => 1),
        '1_2' => array('id' => 1, 'foo'=>'foo_i18n_1_lang_2', 'lang_id' => 2),
        '2_1' => array('id' => 2, 'foo'=>'foo_i18n_2_lang_1', 'lang_id' => 1),
        '3_2' => array('id' => 3, 'foo'=>'foo_i18n_3_lang_2', 'lang_id' => 2),
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach ($this->fixture as $id => $data) {
            $valString .= "('" . $data['bar']. "'),";
        }
        $valString = substr($valString, 0,  -1);

        $this->db->query('INSERT INTO `simple_stubSimple` (`bar`) VALUES ' . $valString);

        $valString = '';
        foreach ($this->fixture_i18n as $data) {
            $valString .= "(" . $data['id'] . ", " . $data['lang_id']. ", '" . $data['foo'] . "'),";
        }
        $valString = substr($valString, 0,  -1);

        $this->db->query('INSERT INTO `simple_stubSimple_lang` (`id`, `lang_id`, `foo`) VALUES ' . $valString);
    }

    public function tearDown()
    {
        $this->cleardb();
        systemConfig::$i18n = false;
    }

    public function setUp()
    {
        $this->mapper = new stubMapper('simple');
        $this->mapper->setMap($this->map);
        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('stubsimple', 1)");

        systemConfig::$i18n = 'ru';
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `simple_stubSimple`');
        $this->db->query('TRUNCATE TABLE `simple_stubSimple_lang`');
        $this->db->query('TRUNCATE TABLE `sys_obj_id`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
    }

    public function testSearchByKey()
    {
        $this->fixture();
        $toolkit = systemToolkit::getInstance();
        $toolkit->setLang(1);
        $this->assertEqual($toolkit->getLang(), 1);

        $item = $this->mapper->searchByKey(1);
        $this->assertEqual($item->getFoo(), $this->fixture_i18n['1_1']['foo']);
        $this->assertEqual($item->getLangId(), 1);
        $this->mapper->resetLangId();

        $toolkit->setLang(2);
        $item = $this->mapper->searchByKey(1);
        $this->assertEqual($item->getFoo(), $this->fixture_i18n['1_2']['foo']);

        $item = $this->mapper->searchByKey(2);
        $this->assertNull($item);

        $item = $this->mapper->searchByKey(3);
        $this->assertEqual($item->getFoo(), $this->fixture_i18n['3_2']['foo']);
        $this->assertEqual($item->getLangId(), 2);
    }

    public function testSearchByLangField()
    {
        $this->fixture();
        $toolkit = systemToolkit::getInstance();
        $toolkit->setLang(1);
        $this->assertEqual($toolkit->getLang(), 1);

        $item = $this->mapper->searchOneByField('foo', $value = 'foo_i18n_1_lang_1');

        $this->assertEqual(1, $item->getId());
        $this->assertEqual($value, $item->getFoo());
    }

    public function testDelete()
    {
        $this->fixture();
        $this->assertEqual($this->countRecord(), array(3, 4));

        $this->mapper->delete(2);
        $this->assertEqual($this->countRecord(), array(2, 3));

        $this->mapper->delete(1);
        $this->assertEqual($this->countRecord(), array(1, 1));
    }

    public function testInsertSave()
    {
        $toolkit = systemToolkit::getInstance();
        $toolkit->setLang(1);

        $simple = $this->mapper->create();
        $simple->setBar($bar = 'bar');
        $simple->setFoo($foo = 'foo_1');
        $this->mapper->save($simple);

        $this->assertEqual($this->countRecord(), array(1, 1));
        $item = $this->mapper->searchByKey(1);
        $this->assertEqual($item->getId(), 1);
        $this->assertEqual($item->getFoo(), $foo);
    }

    public function testInsertWithoutLangFields()
    {
        $toolkit = systemToolkit::getInstance();
        $toolkit->setLang(1);

        $simple = $this->mapper->create();
        $simple->setBar($bar = 'bar');
        //$simple->setFoo($foo = 'foo_1');
        $this->mapper->save($simple);

        $this->assertEqual($this->countRecord(), array(1, 1));
        $item = $this->mapper->searchByKey(1);
        $this->assertEqual($item->getId(), 1);
        $this->assertNull($item->getFoo());
    }

    public function testUpdateSameLang()
    {
        $this->fixture();
        $toolkit = systemToolkit::getInstance();
        $toolkit->setLang(1);

        $item = $this->mapper->searchByKey(1);

        $item->setFoo($foo = 'new_i18n_foo');
        $item->setBar($bar = 'new_bar');
        $this->mapper->save($item);

        $new_item = $this->mapper->searchByKey(1);
        $this->assertEqual($new_item->getFoo(), $foo);
        $this->assertEqual($new_item->getBar(), $bar);
    }

    public function testUpdateWithNewLang()
    {
        $this->fixture();
        $toolkit = systemToolkit::getInstance();
        $toolkit->setLang(1);

        $item = $this->mapper->searchByKey(2);
        $this->assertEqual($item->getFoo(), $this->fixture_i18n['2_1']['foo']);
        $this->mapper->resetLangId();

        $toolkit->setLang(2);
        $item2 = $this->mapper->searchByKey(2);
        $this->assertNull($item2);
        $this->mapper->resetLangId();

        $this->mapper->setLangId(2);
        $item3 = $this->mapper->searchByKey(2);
        $item3->setFoo($foo = 'new_foo_lang_2');
        $item3->setBar($bar = 'new_bar');
        $this->mapper->save($item3);
        $this->mapper->resetLangId();

        $toolkit->setLang(2);
        $item4 = $this->mapper->searchByKey(2);
        $this->assertEqual($item4->getFoo(), $foo);
        $this->assertEqual($item4->getBar(), $bar);
    }

    public function testSortingByLangFields()
    {
        $map = $this->map;
        $map['foo']['orderBy'] = '1';
        $map['foo']['orderByDirection'] = 'DESC';

        $this->fixture();
        $this->mapper->setMap($map);
        $res = $this->mapper->searchAll();

        $i = count($res);

        $this->assertEqual($i, 2);

        $first = reset($res);
        $this->assertEqual($first->getId(), 3);

        $next = next($res);
        $this->assertEqual($next->getId(), 1);
    }

    private function countRecord()
    {
        $stmt = $this->db->query("SELECT count(*) FROM `simple_stubSimple`");
        $count = $stmt->fetch(PDO::FETCH_NUM);

        $stmt = $this->db->query("SELECT count(*) FROM `simple_stubSimple_lang`");
        $count2 = $stmt->fetch(PDO::FETCH_NUM);

        return array((int)$count[0], (int)$count2[0]);
    }
}

?>