<?php
fileLoader::load('db/simpleDelete');

class simpleDeleteTest extends unitTestCase
{
    private $delete;
    /**
     * @var criteria
     */
    private $criteria;

    public function setUp()
    {
        $this->criteria = new criteria();
        $this->delete = new simpleDelete($this->criteria);
    }

    public function testDeleteAll()
    {
        $this->criteria->setTable('table');
        $this->assertEqual($this->delete->toString(), "DELETE FROM `table`");
    }

    public function testDeleteWithConditions()
    {
        $this->criteria->setTable('table');
        $this->criteria->add('id', 100);
        $this->assertEqual($this->delete->toString(), "DELETE FROM `table` WHERE `table`.`id` = 100");
    }
}

?>