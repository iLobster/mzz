<?php

fileLoader::load('codegenerator/fileGenerator');

class fileGeneratorTest extends UnitTestCase
{
    private $dir;

    private $generator;

    public function __construct()
    {
        $this->dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sandbox';
        $this->tearDown();
    }

    public function setUp()
    {
        //$this->generator = new directoryGenerator($this->dir);
    }

    public function tearDown()
    {
        $this->delete($this->dir, false);
    }

    private function delete($dir, $self = true)
    {
        foreach (glob($dir . '/*') as $nested) {
            if (is_dir($nested)) {
                $this->delete($nested);
            } else {
                unlink($nested);
            }
        }

        if ($self) {
            rmdir($dir);
        }
    }

    public function testCreateSimple()
    {
        $generator = new fileGenerator($this->dir);
        $generator->create('file', 'contents');
        $generator->run();

        $this->assertTrue($this->isFileExists('file'));
        $this->assertEqual($this->getContents('file'), 'contents');
    }

    public function testCreateWithSubfolder()
    {
        $generator = new fileGenerator($this->dir);
        $generator->create('subdir/file', 'contents');
        $generator->run();

        $this->assertTrue($this->isFileExists('subdir/file'));
        $this->assertEqual($this->getContents('subdir/file'), 'contents');
    }

    public function testOverwriteException()
    {
        $generator = new fileGenerator($this->dir);
        $generator->create('file', 'contents');
        $generator->run();

        try {
            $generator->create('file', 'new');
            $generator->run();
            //$this->fail();
        } catch (fileGeneratorExistsException $e) {
            $this->pass();
        }

        $this->assertEqual($this->getContents('file'), 'contents');
    }

    private function isFileExists($expected)
    {
        return is_file($this->dir . DIRECTORY_SEPARATOR . $expected);
    }

    private function getContents($expected)
    {
        if (!$this->isFileExists($expected)) {
            return null;
        }

        return file_get_contents($this->dir . DIRECTORY_SEPARATOR . $expected);
    }
}

?>