<?php
/* vim: set number autoindent tabstop=2 shiftwidth=2 softtabstop=2: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt                                   |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author:  Giuseppe Dessì <thesee@fastwebnet.it>                       |
// +----------------------------------------------------------------------+
// $Id$

/**
 * Class to dynamically create an HTML input text element that
 * at every keypressed javascript event, call by XMLHttpRequest for sending
 * the request to the server. A PHP script or XML or a static file returns
 * a response in a arbitrary format, depending on the our needed.
 * We can see the data on a live dropdown select
 *
 * @author       Giuseppe Dessì <thesee@fastwebnet.it>
 */
require_once 'HTML/QuickForm/text.php';

class HTML_QuickForm_LiveSearch_Select extends HTML_QuickForm_text
{
    // {{{ properties

     /**
     * Options for the LiveSearch_Select input text element
     *
     * @var       array
     * @access    private
     */
    var $_options = array();

    /**
     * Original name of element
     *
     * @var       string
     * @access    private
     */
    var $realName = '';

    /**
     * The values passed by the hidden element
     *
     * @var array
     * @access private
     */
    var $_value = null;
    var $_hidden_value = null;

    // }}}
    // {{{ constructor

    /**
     * Class constructor
     *
     * @param     string    $elementName    (required)Input field name attribute
     * @param     string    $elementLabel   (required)Input field label in form
     * @param     array     $options        (optional)LiveSearch_Select options
     * @param     mixed     $attributes     (optional)Either a typical HTML attribute string
     *                                      or an associative array. Date format is passed along the attributes.
     * @access    public
     * @return    void
     */
    function HTML_QuickForm_LiveSearch_Select($elementName = null, $elementLabel = null, $options = null, $attributes = null)
    {
        $this->HTML_QuickForm_text($elementName, $elementLabel, $attributes);
        $this->_persistantFreeze = true;
        $this->_type = 'livesearch_select';
        if (isset($options)) {
            $this->setOptions($options);
        }
    } //end constructor
    /**
     * Gets the private name for the element
     *
     * @param   string  $elementName The element name to make private
     *
     * @access public
     * @return string
     */
    function getPrivateName($elementName)
    {
        return 'q'.$elementName;
    }
    // }}}
    // {{{ setOptions()

    /**
     * Sets the element's value
     *
     * @param    mixed   Element's value
     * @access   public
     */
    function setValue($value)
    {
        $this->_hidden_value = $value;
        if (isset($this->_options['callback']) AND is_callable($this->_options['callback']) ) {
            if (isset($this->_options['dbh']) ) {
                $dbh = $this->_options['dbh'];
            } else {
                $dbh = NULL;
            }
            $this->_value = call_user_func($this->_options['callback'], $dbh, $value);
            $this->updateAttributes(array(
                                        'value' => $this->_value
                                        )
                                    );
        } else {
            $this->updateAttributes(array(
                                        'value' => $value
                                        )
                                    );
        }
    }
    /**
     * Gets the element's value
     *
     * @param    mixed   Element's value
     * @access   public
     */
    function getValue($internal = NULL)
    {
        if ($this->_flagFrozen) {
            if ($internal) {
                return $this->_value;
            } else {
                return $this->_hidden_value;
            }
        } else {
            return $this->_hidden_value;
        }
    }
    /**
     * Sets the options for the LiveSearch_Select input text element
     *
     * @param     array    $options    Array of options for the LiveSearch_Select input text element
     * @access    public
     * @return    void
     */
    function setOptions($options)
    {
        $this->_options = $options;
    } // end func setOptions

    // }}}
    // {{{ getFrozenHtml()

    /**
     * Returns the value of field without HTML tags
     *
     * @since     1.0
     * @access    public
     * @return    string
     */
    function getFrozenHtml()
    {
        $value = $this->getValue(true);
        $id = $this->getAttribute('id');
        return ('' != $value ? htmlspecialchars($value): '&nbsp;').'<input' . $this->_getAttrString(array(
                       'type'  => 'hidden',
                       'name'  => $this->realName,
                       'value' => $this->getValue()
                   ) + (isset($id)? array('id' => $id): array())) . ' />';
    } //end func getFrozenHtml

    // }}}
    // {{{ toHtml()
    /**
     * Returns Html for the LiveSearch_Select input text element
     *
     * @access      public
     * @return      string
     */
    function toHtml()
    {
        $this->realName = $this->getName();
        $class = '';
        $liveform = '';
        $scriptLoad = '';
        $style = 'display: block;';
        $divstyle = ' class="divstyle" ';
        $ulstyle = ' class="ulstyle" ';
        $listyle = ' class="listyle" ';
        $zeroLength = 0;
        $printStyle = 1;
        $this->updateAttributes(array(
                                      'name' => $this->getPrivateName($this->realName)
                                     )
                                );
        if (isset($this->_options['style']) AND $this->_options['style'] != '') {
            $style = $this->_options['style'];
        }
         if (isset($this->_options['class']) AND $this->_options['class'] != '') {
            $class = $this->_options['class'];
        }
        if (isset($this->_options['divstyle']) AND $this->_options['divstyle'] != '') {
            $divstyle =  ' class="'.$this->_options['divstyle'].'" ';
        }
        if (isset($this->_options['ulstyle']) AND $this->_options['ulstyle'] != '') {
            $ulstyle =  ' class="'.$this->_options['ulstyle'].'" ';
        }
        if (isset($this->_options['listyle']) AND $this->_options['listyle'] != '') {
            $listyle =  ' class="'.$this->_options['listyle'].'" ';
        }
        if (isset($this->_options['searchZeroLength']) AND $this->_options['searchZeroLength'] == 1) {
            $zeroLength = 1;
        } else {
            $zeroLength = 0;
        }
        if (isset($this->_options['printStyle']) AND $this->_options['printStyle'] != 1) {
            $printStyle = 0;
        }
        if (isset($this->_options['autoComplete']) AND $this->_options['autoComplete'] != 0) {
            $this->updateAttributes(array(
                                            'autocomplete' => 'off'
                                        )
                                    );
        }
        $this->updateAttributes(array(
                                      'onkeyup' => 'javascript:liveSearchKeyPress(this, event, \''.$this->getName().'Result\', \'target_'.$this->_options['elementId'].'\', \''.$this->_options['elementId'].'\', \''.$this->realName.'\', '.$zeroLength.');',//'javascript:'.$this->getName().'ObjLS.liveSearchKeyPress(this, event);disable();',
                                      'onblur' => 'javascript:liveSearchHide(\''.$this->getName().'Result\');',
                                      'id' => $this->_options['elementId'],
                                      'style' => $style,
                                      'class' => $class,
                                      )
                               );
        if ($this->_flagFrozen) {
            return $this->getFrozenHtml();
        } else {
            $liveform .= '
<div'.$divstyle.'id="'.$this->getName().'Result">
    <ul'.$ulstyle.'id="target_'.$this->_options['elementId'].'">
        <li'.$listyle.'> </li>
    </ul>
</div>';
            
            $scriptLoad .= "
<script type='text/javascript' src=\"{$this->_options['server']}?client=Util,main,dispatcher,httpclient,request,json,loading,queues,QfLiveSearch&amp;stub={$this->_options['searchClassname']}\"></script>";

            if (!defined('HTML_QUICKFORM_LIVESEARCH_EXISTS')) {
                if ($printStyle != 0) {
                    $scriptLoad = <<<EOS
<style type="text/css">
.divstyle {
    position: absolute;
    background-color: #aaa;
    z-index: 1;
    min-width: 140px;
    margin: 1px 0px 2px 0px;
    padding: 0px;
    float:left;
    clear:left;
    background: url(shadowAlpha.png) no-repeat bottom right !important;
    background: url(shadow.gif) no-repeat bottom right;
    margin: 10px 0 10px 10px !important;
    padding: 0px;
    display: none;
}

.ulstyle {
    list-style-type: none;
    position: relative;
    right: 0px;
    z-index: 1;
    margin: 0px;
    padding: 0px;
}

.listyle {
    text-indent: -20px;
    z-index: 1;
    padding: 0px 15px 3px 20px;
    padding-bottom: 2px;
    padding-top: 2px;
    line-height:15px;
    margin-bottom: 0px;
}
.outerUl {
    list-style-type: none;
    position: relative;
    right: 1px;
    z-index: 1;
    margin: 0px;
    padding: 0px;
    background-color: #FFFFFF;
    color: inherit;
    bottom:6px;
    right: 6px;
    border: 1px solid #999999;
    padding:4px;
    margin: 0px 0px 0px 0px;
    text-indent: -20px;
    padding: 0px 15px 3px 20px;
    margin-bottom: -5px;
    margin-top: 0px;
    padding-top: 0px;
    margin: 0px;
    padding: 0px;
}
.outerLi {
    text-indent: -20px;
    z-index: 1;
    padding: 0px 15px 3px 20px;
    padding-bottom: 2px;
    padding-top: 2px;
    line-height:15px;
    margin-bottom: 0px;
}
</style>
EOS;
                }
                $scriptLoad .= "
<script type='text/javascript'>//<![CDATA[
callback = {};
function searchRequest(searchBox, callfunc) {
    eval(\"remoteLiveSearch.\"+callfunc+\"(searchBox.value)\");
}
//]]>
</script>

";

                define('HTML_QUICKFORM_LIVESEARCH_EXISTS', true);
            }
            $scriptLoad .= '
<script type="text/javascript">//<![CDATA[
callback.'.$this->_options['elementId'].' = function(result) {
    var  res = document.getElementById(\''.$this->getName().'Result\');
    res.style.display = "block";
    var out = "<?xml version=\'1.0\' encoding=\'utf-8\'  ?><ul class=\"outerUl\" >";
    
    var exists = false;
    var inArray = false;
    
    if (result == \'notfound\') {
        ' . $this->_options['onNotFound'] . '
    } else {
        ' . $this->_options['onFound'] . '
            for(var i in result) {
                if (i != \'______array\') {
                    out += "<li class=\"outerLi\"><a class=\"searchItem\" href=\"#\" value=\""+i+"\" text=\""+result[i]+"\" onmouseover=\"liveSearchHover(this);\" onmousedown=\"liveSearchClicked(this.getAttribute(\'value\'), this.getAttribute(\'text\'), \''.$this->_options['elementId'].'\', \''.$this->realName.'\'); ' . $this->_options['onFound'] . '\">"+result[i]+"</a></li>";
                    if (document.getElementById(\'' . $this->_options['elementId'] . '\').value == result[i]) {
                        inArray = true;
                    }
                    exists = true;
                }
            }
            
            if (!inArray) {
                ' . $this->_options['onNotFound'] . '
            }
    }
    if (exists) {
        out += "</ul>";
        document.getElementById(\'target_'.$this->_options['elementId'].'\').innerHTML = out;
    } else {
        liveSearchHide(\''.$this->getName().'Result\');
    }
}
//]]>
</script>

';
                    if (!defined('HTML_QUICKFORM_JS_INIT_EXISTS')) {
                        $scriptLoad .= '

<script type="text/javascript">//<![CDATA[
    var remoteLiveSearch = new ' . $this->_options['searchClassname'] . '(callback);
    remoteLiveSearch.dispatcher.queue = \'rls\';
    HTML_AJAX.queues[\'rls\'] = new HTML_AJAX_Queue_Interval_SingleBuffer('.(int)$this->_options['buffer'].');
//]]>
</script>
';
                        //define('HTML_QUICKFORM_JS_INIT_EXISTS', true);
                    }
            $scriptLoad .= '
<input type="hidden" name="'.$this->realName.'" id="'.$this->realName.'" value="'.$this->_hidden_value.'" />'."\n";


        }
    return $scriptLoad.parent::toHtml().$liveform;
    }// end func toHtml

    // }}}
} // end class HTML_QuickForm_LiveSearch_Select
if (class_exists('HTML_QuickForm')) {
    HTML_QuickForm::registerElementType('livesearch_select', 'HTML/QuickForm/livesearch_select.php', 'HTML_QuickForm_LiveSearch_Select');
}
?>
