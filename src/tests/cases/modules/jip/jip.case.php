<?php

fileLoader::load('modules/jip/jip');

class jipTest extends unitTestCase
{
    public function setUp()
    {
    }

    public function testAddAndGetItem()
    {
        $jip = new jip('test_12');
        $this->assertFalse($jip->hasItem('not_exists'));

        try {
        	$jip->getItem('not_exists');
        	$this->fail('No exception.');
        } catch (mzzRuntimeException $e) {
            $this->pass();
        }

        $jip->addItem('edit', $options = array('title' => 'Edit', 'icon' => 'edit.gif'));
        $this->assertEqual($jip->getItem('edit'), $options);
    }

    public function testGetJip()
    {
        $jip = new jip('test_1', 'cases/modules/jip/templates/jip_test.tpl');
        $jip->setLangs(array('en' => 'en'));
        $jip->addItem('edit', $options = array('title' => 'Edit', 'icon' => 'edit.gif', 'lang' => 'en'));
        $jip->addItem('delete', $options = array('title' => 'Delete', 'icon' => 'delete.gif', 'lang' => 'en'));
        $this->assertEqual($jip->getJip(), "test_1|title: Edit icon: edit.gif lang_name: en|title: Delete icon: delete.gif lang_name: en|lang: en");
    }
}
?>