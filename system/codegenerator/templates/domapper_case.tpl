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

{{if $mapper_data.module ne $mapper_data.doname}}
fileLoader::load('{{$mapper_data.module}}/{{$mapper_data.doname}}');
{{else}}
fileLoader::load('{{$mapper_data.module}}');
{{/if}}
fileLoader::load('{{$doCaseData.module}}/mappers/{{$doCaseData.mapperName}}');

class {{$doCaseData.mapperName}}Test extends unitTestCase
{
    private $mapper;
    private $db;
    private $map;

    public function __construct()
    {
        $this->map = array('id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId' ),        
        'created' => array ('name' => 'created', 'accessor' => 'getCreated', 'mutator' => 'setCreated'),
        'updated' => array ('name' => 'updated', 'accessor' => 'getUpdated', 'mutator' => 'setUpdated')
        );

        $this->db = DB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
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