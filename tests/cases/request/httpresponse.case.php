<?php

fileLoader::load('request/httpResponse');
fileLoader::load('template/mzzSmarty');
mock::generatePartial('mzzSmarty', 'mockmzzSmarty', array('assign'));

class httpResponseTest extends unitTestCase
{
    protected $response;

    function setUp()
    {
        // need smarty-mock here:
        $this->response = new httpResponse(new mockmzzSmarty);
        Reflection::export(new ReflectionClass('mockmzzSmarty'));
    }

    public function tearDown()
    {
    }

    public function testHttpResponse()
    {
        $this->response->append('test_add');
        $this->response->append('_content');
        $this->response->append('_done');

        // start buffer
        ob_start();
        $this->response->send();
        // read buffer
        $content = ob_get_contents();
        // and clean buffer
        ob_end_clean();

        $this->assertEqual($content, 'test_add_content_done');
    }

    public function testHttpRequestHeaders()
    {
        $headers = array('name1' => 'value_1', 'name2' => 'value_2', 'name3' => 'value_3');
        foreach ($headers as $name => $value) {
            $this->response->setHeader($name, $value);
        }

        $this->assertEqual($this->response->getHeaders(), $headers);
    }
    public function testSetTitle()
    {
        //
    }

}

?>