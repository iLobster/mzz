<?php
fileLoader::load('controller/sectionMapper');

class sectionMapperTest extends unitTestCase
{
    private $mapper;

    public function __construct()
    {
    }

    public function setUp()
    {
        $this->mapper = new sectionMapper(dirname(__FILE__) . '/fixtures');
    }

    public function tearDown()
    {
    }

    public function testSectionMapper()
    {
        $section = "test";
        $action = "foo";
        $this->assertEqual($this->mapper->getTemplateName($section, $action), "act/test/foo.tpl");

        $section = "test";
        $action = "bar";
        $this->assertEqual($this->mapper->getTemplateName($section, $action), "act/test/bar.tpl");
    }

    public function testSectionMapperFalse()
    {
        $section = "__not_exists__";
        $action = "__not_exists__";

        try {
            $this->mapper->getTemplateName($section, $action);
            $this->fail('�� ���� ������� ����������');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/�� ������ �������� ������/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('������� �� ��������� ����������');
        }

        $section = "test";
        $action = "__not_exists__";

        try {
            $this->mapper->getTemplateName($section, $action);
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/�� ������ �������� ������/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('������� �� ��������� ����������');
        }
    }

    public function __destruct()
    {
    }

}

?>