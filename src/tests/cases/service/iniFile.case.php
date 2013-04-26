<?php

fileLoader::load('service/iniFile');

class iniFileTest extends unitTestCase
{
    protected $content;

    function setUp()
    {
        $this->content = array('a' => array('field1' => 'value1', 'field2' => 'value2'), 'b' => array('field3' => 'value3'));

        $this->filename = systemConfig::$pathToTemp . '/sample.ini';

        $content = '';
        foreach ($this->content as $section => $fields) {
            $content .= '[' . $section . "]\r\n";
            foreach ($fields as $key => $value) {
                $content .= $key . ' = "' . $value . "\"\r\n";
            }
            $content .= "\r\n";
        }
        file_put_contents($this->filename, $content);
    }

    public function tearDown()
    {
        if (is_file($this->filename)) {
            unlink($this->filename);
        }
    }

    public function testGetContentsAndChange()
    {
        $file = new iniFile($this->filename);
        $content = $file->read();

        $this->assertEqual($this->content, $content);

        $content['new'] = array(1, 2, 3);
        $file->write($content);

        $this->assertEqual($content, $file->read());
    }

    public function testWriteArray()
    {
        $this->tearDown();
        $this->assertFalse(is_file($this->filename));

        $file = new iniFile($this->filename);
        $file->write($this->content);

        $file2 = new iniFile($this->filename);

        $this->assertEqual($file2->read(), $this->content);
    }
}

?>