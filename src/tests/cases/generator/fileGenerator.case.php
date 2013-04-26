<?php

fileLoader::load('codegenerator/fileGenerator');

class fileGeneratorTest extends UnitTestCase
{
    private $for_windows = array(
        'testCreateSimple',
        'testCreateWithSubfolder',
        'testOverwriteException',
        'testRename',
        'testIniTransformator');

    private $dir;

    private $generator;

    public function __construct()
    {
        $this->dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sandbox';
        $this->tearDown();
    }

    public function _isTest($method)
    {
        if (strpos(PHP_OS, 'WIN') !== false && !in_array($method, $this->for_windows)) {
            return false;
        }

        return parent::_isTest($method);
    }

    public function setUp()
    {
        $this->generator = new fileGenerator($this->dir);
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
        $this->generator->create('file', 'contents');
        $this->generator->run();

        $this->assertTrue($this->isFileExists('file'));
        $this->assertEqual($this->getContents('file'), 'contents');
    }

    public function testCreateWithSubfolder()
    {
        $this->generator->create('subdir/file', 'contents');
        $this->generator->run();

        $this->assertTrue($this->isFileExists('subdir/file'));
        $this->assertEqual($this->getContents('subdir/file'), 'contents');
    }

    public function testOverwriteException()
    {
        $this->generator->create('file', 'contents');
        $this->generator->run();

        try {
            $this->generator->create('file', 'new');
            $this->generator->run();
            $this->fail();
        } catch (fileGeneratorExistsException $e) {
            $this->pass();
        }

        $this->assertEqual($this->getContents('file'), 'contents');
    }

    public function testRename()
    {
        $this->generator->create('file');
        $this->generator->run();

        $this->generator->rename('file', 'new');
        $this->generator->run();

        $this->assertFalse($this->isFileExists('file'));
        $this->assertTrue($this->isFileExists('new'));
    }

    public function testDelete()
    {
        $this->generator->create('file');
        $this->generator->run();

        $this->generator->delete('file');
        $this->generator->run();

        $this->assertFalse($this->isFileExists('file'));
    }

    public function testCreateMode()
    {
        $generator = new fileGenerator($this->dir, 0666);
        $generator->create('all');
        $generator->create('me', '', 0600);
        $generator->run();

        $this->assertEqual($this->getAccessMode('all'), 'rw-rw-rw-');
        $this->assertEqual($this->getAccessMode('me'), 'rw-------');

        $generator->create('ro/file', '', 0640);
        $generator->run();

        $this->assertEqual($this->getAccessMode('ro'), 'rwxr-x---');
    }

    public function testIniTransformator()
    {
        fileLoader::load('codegenerator/fileIniTransformer');

        $data = array('section' => array('key' => 'value'));

        $this->generator->create('file.ini');
        $this->generator->run();

        $this->generator->edit('file.ini', new fileIniTransformer('merge', $data));
        $this->generator->run();

        $this->assertEqual($this->getContents('file.ini'), "[section]\r\nkey = \"value\"");

        $data = array('section2' => array('key2' => 'value2'));
        $this->generator->edit('file.ini', new fileIniTransformer('merge', $data));
        $this->generator->run();

        $this->assertEqual($this->getContents('file.ini'), "[section]\r\nkey = \"value\"\r\n\r\n[section2]\r\nkey2 = \"value2\"");

        $data = array('section' => array());
        $this->generator->edit('file.ini', new fileIniTransformer('merge', $data));
        $this->generator->run();

        $this->assertEqual($this->getContents('file.ini'), "[section]\r\n\r\n[section2]\r\nkey2 = \"value2\"");
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

    private function getAccessMode($directory)
    {
        $perms = fileperms($this->dir . DIRECTORY_SEPARATOR . $directory);

        $result = '';

        $result .= (($perms & 0x0100) ? 'r' : '-');
        $result .= (($perms & 0x0080) ? 'w' : '-');
        $result .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));

        $result .= (($perms & 0x0020) ? 'r' : '-');
        $result .= (($perms & 0x0010) ? 'w' : '-');
        $result .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));

        $result .= (($perms & 0x0004) ? 'r' : '-');
        $result .= (($perms & 0x0002) ? 'w' : '-');
        $result .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));

        return $result;
    }
}

?>