<?php

class RewriteTest extends unitTestCase
{
    private $rewrite;
    private $filepath;

    public function __construct()
    {
        $this->fixtureRewriteXmlConfig();
    }

    function setUp()
    {
        $this->rewrite = new Rewrite($this->filepath);
    }

    public function tearDown()
    {
        $this->rewrite->clear();
    }

    public function fixtureRewriteXmlConfig()
    {
        $xml = '<?xml version="1.0" standalone="yes"?>
            <rules>
            	<test>
            		<rule pattern="/">/foo</rule>
            		<rule pattern="baz">bar</rule>
            		<rule pattern="test_pattern">result</rule>
            	</test>
            </rules>';

        $this->filepath = systemConfig::$pathToTemp . '/simple_rewrite.xml';
        file_put_contents($this->filepath, $xml);
    }

    public function testRewriteRule()
    {
        $this->assertEqual(Rewrite::createRule('/news/([0-9]{0,2})/?', '/news/$1/view'),
        array('pattern' => '#^/news/([0-9]{0,2})/?$#i',
        'replacement' => '/news/$1/view')
        );
    }
    public function testRewrite()
    {
        $this->rewrite->addRule('/news/([0-9]{0,2})/([0-9]{0,2})/([0-9]{0,4})/?', '/news/$3/$2/$1/view');

        $this->assertEqual($this->rewrite->process('/news/12/01/2005/'), "/news/2005/01/12/view");
    }

    public function testRewriteGroup()
    {
        $rule[] = Rewrite::createRule("/one/([a-z]+)", '/one/two/$1/');
        $rule[] = Rewrite::createRule("/one/two/([a-z]+)/", '/one/two/$1/view');
        $rule[] = Rewrite::createRule("/one/two/([a-z0-9]+)/view", '/my/$1/list');

        $this->rewrite->addGroupRule($rule);
        $this->assertEqual($this->rewrite->process('/one/two/test/view'), "/my/test/list");
    }

    public function testRewriteMix()
    {
        $this->rewrite->addRule('/foo/([a-z]+)/?', '/foo/$1/view');

        $rule[] = Rewrite::createRule("/one/two/([a-z]+)", '/my/$1/list');
        $this->rewrite->addGroupRule($rule);

        $this->rewrite->addRule('/bar/([a-z]+)/?', '/bar/$1/list');

        $this->assertEqual($this->rewrite->process('/one/two/test'), "/my/test/list");
        $this->assertEqual($this->rewrite->process('/bar/test'), "/bar/test/list");
        $this->assertEqual($this->rewrite->process('/foo/test'), "/foo/test/view");
    }

    public function testRewriteNotRewrited()
    {
        $this->rewrite->addRule('/foo/([a-z]+)/?', '/foo/$1/view');
        $rule[] = Rewrite::createRule("/one/two/([a-z]+)", '/my/$1/list');
        $this->rewrite->addGroupRule($rule);

        $this->assertEqual($this->rewrite->process('/maybe/work'), "/maybe/work");
    }

    public function testGetRules()
    {
        $this->rewrite->loadRules('test');
        $this->assertEqual($this->rewrite->process('/'), '/foo');
        $this->assertEqual($this->rewrite->process('baz'), 'bar');
        $this->assertEqual($this->rewrite->process('test_pattern'), 'result');
    }

    public function __destruct()
    {
        unlink($this->filepath);
    }
}
?>