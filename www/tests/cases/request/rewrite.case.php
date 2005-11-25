<?php
require_once '../../system/request/rewrite.php';

class RewriteTest extends unitTestCase
{
    private $rewrite;
    function setUp()
    {
        $this->rewrite = Rewrite::getInstance();
    }

    public function tearDown()
    {
        $this->rewrite->clear();
    }

    public function testRewriteRule()
    {
        $this->assertEqual(Rewrite::createRule('/news/([0-9]{0,2})/?', '/news/$1/view'),
                                               array('pattern' => '/news/([0-9]{0,2})/?',
                                                     'replacement' => '/news/$1/view')
                                               );
    }
    public function testRewrite()
    {
        $this->rewrite->addRule('#/news/([0-9]{0,2})/([0-9]{0,2})/([0-9]{0,4})/?#i', '/news/$3/$2/$1/view');

        $this->assertEqual($this->rewrite->process('/news/12/01/2005/'), "/news/2005/01/12/view");
    }


    public function testRewriteGroup()
    {
      $rule[] = Rewrite::createRule("#/one/([a-z]+)#i", '/one/two/$1/');
      $rule[] = Rewrite::createRule("#/one/two/([a-z]+)/#i", '/one/two/$1/view');
      $rule[] = Rewrite::createRule("#/one/two/([a-z]+)/view#i", '/my/$1/list');

      $this->rewrite->addGroupRule($rule);
      $this->assertEqual($this->rewrite->process('/one/test'), "/my/test/list");
    }

    public function testRewriteMix()
    {
      $this->rewrite->addRule('#/foo/([a-z]+)/?#i', '/foo/$1/view');

      $rule[] = Rewrite::createRule("#/one/([a-z]+)#i", '/one/two/$1');
      $rule[] = Rewrite::createRule("#/one/two/([a-z]+)#i", '/my/$1/list');
      $this->rewrite->addGroupRule($rule);

      $this->rewrite->addRule('#/bar/([a-z]+)/?#i', '/bar/$1/list');

      $this->assertEqual($this->rewrite->process('/one/test'), "/my/test/list");
      $this->assertEqual($this->rewrite->process('/bar/test'), "/bar/test/list");
      $this->assertEqual($this->rewrite->process('/foo/test'), "/foo/test/view");
    }
}
?>