<?php

fileLoader::load('template/plugins/prefilter.i18n');
fileLoader::load('cases/smarty/stubSmarty');

mock::generate('stubSmarty');

class mzzSmartyI18nFunctionTest extends unitTestCase
{
    protected $smarty;
    protected $function;
    public function setUp()
    {
        $this->smarty = new mockstubSmarty();
        $this->smarty->_current_file = 'somemodule/sometemplate.tpl';
        smarty_prefilter_i18n(array('callback' => __CLASS__ . '::stub_callback', 'smarty' => $this->smarty), $this->smarty);
    }

    public function testSimple()
    {
        $tpl = "{_ foo}";
        $this->assertEqual(smarty_prefilter_i18n($tpl, $this->smarty), 'foo-somemodule-en-');
    }

    public function testWithQuotes()
    {
        $tpl = '{_ "foo bar"}';
        $this->assertEqual(smarty_prefilter_i18n($tpl, $this->smarty), 'foo bar-somemodule-en-');
    }

    public function testConstantPlaceholders()
    {
        $tpl = '{_ "foo bar" first second third fourth ...}';
        $this->assertEqual(smarty_prefilter_i18n($tpl, $this->smarty), 'foo bar-somemodule-en-first second third fourth ...');
    }

    public function testVariablePlaceholders()
    {
        $this->assertEqual(mzz_smarty_i18n_morph('foo ? bar ?', array('a', 'b')), '{php}$i18n = new i18n(); echo $i18n->replacePlaceholders(\'foo ? bar ?\', $this->_tpl_vars["a"] . \' \' . $this->_tpl_vars["b"]); {/php}');
    }

    public function stub_callback($name, $module, $lang, $args, $generatorCallback)
    {
        return $name . '-' . $module . '-' . $lang . '-' . $args;
    }
}

?>