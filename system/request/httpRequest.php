<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id$
*/

fileLoader::load('request/iRequest');

/**
 * httpRequest: ����� ��� ������ � ���������������� ���������.
 * ������ � httpRequest ����� �������� ����� Toolkit.
 *
 * Examples:
 * <code>
 * $httprequest->get('var', SC_GET | SC_COOKIE);
 * $httprequest->get('var2');
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.7.2
 */

define('SC_GET', 1);
define('SC_POST', 2);
define('SC_REQUEST', SC_GET | SC_POST);
define('SC_COOKIE', 4);
define('SC_SERVER', 8);
define('SC_PATH', 16);

class httpRequest implements iRequest
{
    /**#@+
    * @var array
    */
    /**
     * POST-������
     */
    protected $postVars;

    /**
     * GET-������
     */
    protected $getVars;

    /**
     * Cookie
     */
    protected $cookieVars;

    /**
     * �������� ��� ���������� �������� ���������� ����������
     *
     */
    protected $saved;

    /**
     * ���������
     *
     */
    protected $params = null;
    /**#@-*/

    /**
     * ������� ������
     *
     * @var string
     */
    protected $section;

    /**
     * ������� ��������
     *
     * @var string
     */
    protected $action;

    /**
     * ����������� ������
     *
     * @var string
     */
    protected $requestedSection = false;

    /**
     * ����������� ��������
     *
     * @var string
     */
    protected $requestedAction = false;

    /**
     * �����������.
     *
     */
    public function __construct()
    {
        $this->refresh();
    }

    /**
     * ����� ��������� ���������� �� ���������������� �������
     *
     * @param string  $name  ��� ����������
     * @param string  $type  ���, � ������� ����� ������������� ��������
     * @param integer $scope �������� �����, ������������ � ����� �������� ������ ����������
     * @return string|null
     */
    public function get($name, $type = 'mixed', $scope = SC_PATH)
    {
        $result = null;
        $originalName = false;
        if ($bracket = strpos($name, '[')) {
            $originalName = $name;
            $name = substr($name, 0, $bracket);
        }
        $done = false;

        if (!$done && $scope & SC_PATH && !is_null($result = $this->params->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_SERVER && !is_null($result = $this->getServer($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_COOKIE && !is_null($result = $this->cookieVars->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_POST && !is_null($result = $this->postVars->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_GET && !is_null($result = $this->getVars->get($name))) {
            $done = true;
        }

        if ($originalName) {
            $name = $originalName;
            $name = str_replace('[]', '[0]', $name);
            preg_match_all('/\[["\']?(.*?)["\']?\]/', $name, $indexes);
            // or str_replace(array('[]', '][', '[', ']'), array('', '[', '[', ''), substr($name, strpos($name, '[') + 1));
            $indexes = $indexes[1];

            foreach($indexes as $index) {
                if (!isset($result[$index])) {
                    $result = null;
                    break;
                }
                $result = $result[$index];
            }
        }

        if (!empty($result) && $this->isAjax()) {
            if (is_array($result)) {
                array_walk_recursive($result, array($this, 'decodeUTF8'));
            } else {
                $result = $this->decodeUTF8($result);
            }
        }

        if (empty($type) || $type == 'mixed') {
            return $result;
        } else {
            return $this->convertToType($result, $type);
        }
    }

    /**
     * ��������������� �������� ���������� $result � ���� $type
     * ���� $result ������, �� �� ���� ����������� ������ ������� �
     * ���������� �������������� ���������� ������ � ���� ���������
     *
     * @param mixed $result �������� ���������� �� URI
     * @param string $type ���, � ������� ����� ������������� ��������
     * @return mixed
     */
    public function convertToType($result, $type)
    {
        $validTypes = array('array' => 1, 'integer' => 1, 'boolean' => 1, 'string' => 1);
        if (gettype($result) == 'array' && $type != 'array') {
            $result = array_shift($result);
            if (!is_scalar($result)) {
                $result = null;
            }
        }

        if (!($valid = isset($validTypes[$type]))) {
            throw new mzzRuntimeException('�������� ��� ��� ����������: ' . $type);
        }

        if (gettype($result) != $type && $valid && !is_null($result)) {
            settype($result, $type);
        }
        return $result;
    }

    /**
     * ���������� true ���� ������������ ���������� �������� HTTPS
     *
     * @return boolean
     */
    public function isSecure()
    {
        $protocol = $this->getServer('HTTPS');
        return ($protocol === 'on');
    }

    /**
     * ���������� true ���� ������������ AJAX
     *
     * @return boolean
     */
    public function isAjax()
    {
        return isset($_REQUEST['ajax']);
    }

    /**
     * ����� ���������� ��������, ������� ��� ����������� ��� �������� ������.
     *
     * @return string|null ��������� ��������: GET, HEAD, POST, PUT
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    /**
     * ����� ��������� ���������� �� ���������������� ������� _SERVER
     *
     * @param string $name ��� ����������
     * @return string|null
     */
    private function getServer($name)
    {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : null;
    }

    /**
     * ������������� ������� ������
     * ������ ������������� �������� ��������� ����������� �������
     *
     * @param string $section
     */
    public function setSection($section)
    {
        if ($this->requestedSection === false) {
            $this->requestedSection = $section;
        }
        $this->section = $section;
    }

    /**
     * ������������� ������� ��������
     * ������ ������������� �������� ��������� ����������� ���������
     *
     * @param string $action
     */
    public function setAction($action)
    {
        if ($this->requestedAction === false) {
            $this->requestedAction = $action;
        }
        $this->action = $action;
    }

    /**
     * ���������� ������� ������
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * ���������� ������� ��������
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * ���������� ����������� ������
     *
     * @return string
     */
    public function getRequestedSection()
    {
        return $this->requestedSection;
    }

    /**
     * ���������� ����������� ��������
     *
     * @return string
     */
    public function getRequestedAction()
    {
        return $this->requestedAction;
    }

    /**
     * ��������� ������������� ���������
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value)
    {
        $this->params->set($name, $value);
    }

    /**
     * ��������� ������� ����������. ������������ ��������� ����� ����������
     *
     * @param array $params
     */
    public function setParams(Array $params)
    {
        $this->params = new arrayDataspace($params);
    }

    /**
     * ������� ������� ����������
     *
     * @return array
     */
    public function & getParams()
    {
        return $this->params->export();
    }

    public function exportPost()
    {
        return $this->postVars->export();
    }

    /**
     * ��������� �������� ����, ��������� ����
     *
     * @return string URL
     */
    public function getUrl()
    {
        $protocol = $this->isSecure() ? 'https' : 'http';
        $port = $this->get('SERVER_PORT', 'mixed', SC_SERVER);
        $port = ($port == '80') ? '' : ':' . $port;

        return $protocol . '://' . $this->get('HTTP_HOST', 'mixed', SC_SERVER) . $port . SITE_PATH;
    }

    /**
     * ��������� �������� ���� c �����
     *
     * @return string URL
     */
    public function getRequestUrl()
    {
        $get = $this->getVars->export();
        unset($get['path']);
        return $this->getUrl() . '/' . $this->getPath() . (sizeof($get) ? '?' . http_build_query($get) : '');
    }

    /**
     * ��������� �������� ����
     *
     * @return string PATH
     */
    public function getPath()
    {
        return trim(preg_replace('/(%2F)+/', '/', urlencode($this->get('path', 'mixed', SC_REQUEST))), '/');
    }

    /**
     * ���������� �������� ��������� ����������
     *
     */
    public function save()
    {
        $this->saved[] = array('params' => $this->params->export(), 'section' => $this->getSection(), 'action' => $this->getAction());
    }

    /**
     * �������������� ����������� ����� ���������
     *
     */
    public function restore()
    {
        if (!empty($this->saved)) {
            $saved = array_pop($this->saved);
            $this->params->import($saved['params']);
            $this->setSection($saved['section']);
            $this->setAction($saved['action']);
            return true;
        }
        return false;
    }


    /**
     * ���������� ������ �� ��������� UTF-8 � windows-1251
     *
     * @param string $value ������ � UTF-8
     * @return string ������ � windows-1251
     */
    public function decodeUTF8(&$value)
    {
        $max_count = 5;
        $max_mark = 248;
        $html = '';
        for ($str_pos = 0; $str_pos < strlen($value); $str_pos++) {
            $old_chr = $value[$str_pos];
            $old_val = ord($value[$str_pos]);
            $new_val = 0;
            $utf8_marker = 0;
            if ($old_val > 127) {
                $mark = $max_mark;
                for ($byte_ctr = $max_count; $byte_ctr > 2; $byte_ctr--) {
                    if (($old_val & $mark) == (($mark << 1) & 255)) {
                        $utf8_marker = $byte_ctr - 1;
                        break;
                    }
                    $mark = ($mark << 1) & 255;
                }
            }
            if ($utf8_marker > 1 && isset($value[$str_pos + 1])) {
                $str_off = 0;
                $new_val = $old_val & (127 >> $utf8_marker);
                for ($byte_ctr = $utf8_marker; $byte_ctr > 1; $byte_ctr--) {
                    if ((ord($value[$str_pos + 1]) & 192) == 128) {
                        $new_val = $new_val << 6;
                        $str_off++;
                        $new_val = $new_val | (ord($value[$str_pos + $str_off]) & 63);
                    }
                    else {
                        $new_val = $old_val;
                    }
                }
                $special = array(1025 => 168, 1105 => 184, 1026 => 128, 1027 => 129, 8218 => 130, 1107 => 131,
                8222 => 132, 8230 => 133, 8224 => 134, 8225 => 135, 8364 => 136, 8240 => 137, 1033 => 138,
                8249 => 139, 1034 => 140, 1036 => 141, 1035 => 142, 1039 => 143, 1106 => 144, 8216 => 145,
                8217 => 146, 8220 => 147, 8221 => 148, 8226 => 149, 8211 => 150, 8212 => 151, 65533 => 152,
                8482 => 153, 1113 => 154, 8250 => 155, 1114 => 156, 1116 => 157, 1115 => 158, 1119 => 159,
                1038 => 161, 1118 => 162, 1032 => 163, 164 => 164, 1168 => 165, 166 => 166, 167 => 167, 169 => 169,
                1028 => 170, 171 => 171, 172 => 172, 173 => 173, 174 => 174, 1031 => 175, 176 => 176, 177 => 177,
                1030 => 178, 1110 => 179, 1169 => 180, 181 => 181, 182 => 182, 183 => 183, 8470 => 185, 1108 => 186,
                187 => 187, 1112 => 188, 1029 => 189, 1109 => 190, 1111 => 191
                );

                if (isset($special[$new_val])) {
                    $html .= chr($special[$new_val]);
                } elseif (1040 <= $new_val && $new_val <= 1103) {
                    $html .= chr($new_val - 848);
                } elseif ($new_val < 256 && chr($old_val) == ($chr = chr($new_val))) {
                    $html .= $chr;
                } else {
                    $html .= '&#'.$new_val.';';
                }
                $str_pos = $str_pos + $str_off;
            }
            else {
                $html .= chr($old_val);
                $new_val = $old_val;
            }
        }
        $value = $html;
        return $value;
    }

    public function refresh()
    {
        $this->postVars = new arrayDataspace($_POST);
        $this->getVars = new arrayDataspace($_GET);
        $this->cookieVars = new arrayDataspace($_COOKIE);
        $this->params = new arrayDataspace();
    }
}

?>