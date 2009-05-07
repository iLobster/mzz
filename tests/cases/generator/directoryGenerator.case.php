<?php

fileLoader::load('codegenerator/directoryGenerator');

class directoryGeneratorTest extends UnitTestCase
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
        $this->generator = new directoryGenerator($this->dir);
    }

    public function tearDown()
    {
        $this->delete($this->dir, false);
    }

    private function delete($dir, $self = true)
    {
        foreach (glob($dir . '/*') as $nested) {
            $this->delete($nested);
        }

        if ($self) {
            rmdir($dir);
        }
    }

    public function testSimpleCreate()
    {
        $this->generator->create($name = 'foo');
        $this->generator->run();

        $this->assertTrue($this->isDirectoryExists($name));
    }

    public function testSpecifyDefaultMode()
    {
        $generator = new directoryGenerator($this->dir, 0700);
        $generator->create($user = 'user');
        $generator->create($group = 'group', 0770);
        $generator->run();

        $this->assertEqual($this->getAccessMode($user), 'rwx------');
        $this->assertEqual($this->getAccessMode($group), 'rwxrwx---');
    }

    public function testCreateNestedDirectory()
    {
        $this->generator->create('foo/bar', 0700);
        $this->generator->run();

        $this->assertTrue($this->isDirectoryExists('foo'));
        $this->assertTrue($this->isDirectoryExists('foo/bar'));
        $this->assertEqual($this->getAccessMode('foo/bar'), 'rwx------');
    }

    public function testDenyNotNestedDirs()
    {
        try {
            $this->generator->create($name = 'foo');
            $this->generator->create('../ololo');
            $this->generator->run();
            $this->fail();
        } catch (directoryGeneratorException $e) {
            $this->pass();
            $this->assertFalse($this->isDirectoryExists($name));
        }
    }

    public function testNoRepeat()
    {
        $this->generator->create('foo');
        $this->generator->run();

        $this->assertTrue($this->isDirectoryExists('foo'));

        $this->generator->run();
    }

    public function testNoAccess()
    {
        $this->generator->create('closed', 0000);
        $this->generator->run();
        $this->assertEqual($this->getAccessMode('closed'), '---------');

        try {
            $this->generator->create($not_exists = 'closed/exception');
            $this->fail();
        } catch (directoryGeneratorNoAccessException $e) {
            $this->pass();
        }
        $this->generator->run();

        $this->assertFalse($this->isDirectoryExists($not_exists));
    }

    private function isDirectoryExists($expected)
    {
        return is_dir($this->dir . DIRECTORY_SEPARATOR . $expected);
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