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


fileLoader::load('{{$doCaseData.doName}}');
fileLoader::load('{{$doCaseData.module}}/mappers/{{$doCaseData.mapperName}}');

Mock::generate('{{$doCaseData.mapperName}}');

class {{$doCaseData.doName}}Test extends unitTestCase
{
    private ${{$doCaseData.doName}};
    private $map;
    private $db;
    

    public function setUp()
    {
        $this->map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'something' => array ( 'name' => 'something', 'accessor' => 'getSomething', 'mutator' => 'setSomething')
        );

        $this->db = DB::factory();
        $this->{{$doCaseData.doName}} = new {{$doCaseData.doName}}($this->map);
        $this->mapper = new {{$doCaseData.mapperName}}('{{$doCaseData.doName}}');
        $this->cleardb();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `{{$doCaseData.tableName}}`');
    }


}


?>