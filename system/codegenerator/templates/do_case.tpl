<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */


{{if $mapper_data.module ne $mapper_data.doname}}
fileLoader::load('{{$mapper_data.module}}/{{$mapper_data.doname}}');
{{else}}
fileLoader::load('{{$mapper_data.module}}');
{{/if}}
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