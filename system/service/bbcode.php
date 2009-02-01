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
 * @subpackage toolkit
 * @version $Id$
 */

fileLoader::load('i18n');

/**
 * bbcode: Парсер BB-кодов и смайлов
 *
 * @package system
 * @subpackage service
 * @version 0.1
 */
class bbcode
{
    /**#@+
    * Состояния парсера
    */
    const PARSER_START = 1;
    const PARSER_TEXT = 2;
    const PARSER_TAG_OPENED = 3;
    /**#@-*/

    /**
     * Набор смайлов
     *
     * @var array
     */
    protected $smileys = array(
    ':)' => 'smile'
    );

    /**
     * BB-коды
     *
     * @var array
     */
    protected $tags = array(
    'b' => array(
    'html' => '<strong>%1$s</strong>',
    ),
    'i' => array(
    'html' => '<em>%1$s</em>',
    ),
    'u' => array(
    'html' => '<span style="text-decoration: underline;">%1$s</span>',
    ),
    's' => array(
    'html' => '<strike>%1$s</strike>',
    ),
    'color' => array(
    'html' => '<span style="color: %2$s;">%1$s</span>',
    'permanentWithAttributes' => true,
    'attributes' => array('red', 'blue', 'green')
    ),
    'size' => array(
    'html' => '<font size="+%2$s">%1$s</font>',
    'permanentWithAttributes' => true,
    'attributes' => array('1', '2', '3')
    ),
    'quote' => array(
    'callback' => 'handleQuote'
    ),
    'img' => array(
    'callback' => 'handleImg'
    ),
    'url' => array(
    'callback' => 'handleUrl'
    ),
    'code' => array(
    'callback' => 'handleCode',
    'no_wordwrap' => true,
    'no_smileys' => true
    ),
    );

    /**
     * Кэш смайлов где они хранятся с HTML кодом
     *
     * @var array
     */
    protected $smileys_cache;

    /**
     * Конструктор
     *
     * @param string $content текст, в котором будут заменены bb-коды
     */
    public function __construct($content = null)
    {
        if ($content) {
            $this->content = $content;
        }
    }

    /**
     * Обрабатывает bb-коды в тексте и возвращает результат
     *
     * @param string $content текст, в котором будут заменены bb-коды
     * @return string текст с замененными bb-кодами
     */
    public function parse($content = null)
    {
        if ($content) {
            $this->content = $content;
        }

        $result = $this->parseArray($this->prepareTags($this->buildBBData($this->content)));

        // исключаем xss
        $find = array('/(javascript|about|vbscript):/si', '/&(?![a-z0-9#]+;)/si');
        $replace = array('$1<b></b>:', '&amp;');
        $result = preg_replace($find, $replace, $result);

        return $result;
    }

    /**
     * Собирает массив из текста, который необходим для дальнейшей обработки
     *
     * @param string $text
     * @return array
     */
    protected function buildBBData($text)
    {
        $startPos = 0;
        $strlen = strlen($text);

        $output = array();
        $tmpData = array();

        $state = self::PARSER_START;

        while ($strlen > $startPos) {
            switch ($state) {
                case self::PARSER_START:
                    if (($tagOpenPos = strpos($text, '[', $startPos)) === false) {
                        $tmpData = array(
                        'start' => $startPos,
                        'end' => $strlen
                        );
                        $state = self::PARSER_TEXT;
                    } elseif ($tagOpenPos != $startPos) {
                        $tmpData = array(
                        'start' => $startPos,
                        'end' => $tagOpenPos
                        );
                        $state = self::PARSER_TEXT;
                    } else {
                        $startPos = $tagOpenPos + 1;
                        if ($startPos >= $strlen) {
                            $tmpData = array(
                            'start' => $tagOpenPos,
                            'end' => $strlen
                            );
                            $startPos = $tagOpenPos;
                            $state = self::PARSER_TEXT;
                        } else {
                            $state = self::PARSER_TAG_OPENED;
                        }
                    }
                    break;

                case self::PARSER_TEXT:
                    $end = end($output);
                    if ($end['type'] == 'text') {
                        $output[key($output)]['data'] .= substr($text, $tmpData['start'], $tmpData['end'] - $tmpData['start']);
                    } else {
                        $output[] = array(
                        'type' => 'text',
                        'data' => substr($text, $tmpData['start'], $tmpData['end'] - $tmpData['start'])
                        );
                    }

                    $startPos = $tmpData['end'];
                    $state = self::PARSER_START;
                    break;

                case self::PARSER_TAG_OPENED:
                    if (($tagClosePos = strpos($text, ']', $startPos)) === false) {
                        $tmpData = array(
                        'start' => $startPos - 1,
                        'end' => $startPos
                        );
                        $state = self::PARSER_TEXT;
                        break;
                    }

                    $closing_tag = ($text{$startPos} == '/');
                    if ($closing_tag) {
                        ++$startPos;
                    }

                    $tagOptStartPos = strpos($text, '=', $startPos);
                    if ($closing_tag || $tagOptStartPos === false || $tagOptStartPos > $tagClosePos) {
                        $tagName = strtolower(substr($text, $startPos, $tagClosePos - $startPos));

                        if ($this->isValidTag($tagName, $closing_tag)) {
                            $output[] = array(
                            'type' => 'tag',
                            'name' => $tagName,
                            'option' => false,
                            'closing' => $closing_tag
                            );

                            $startPos = $tagClosePos + 1;
                            $state = self::PARSER_START;
                        } else {
                            $tmpData = array(
                            'start' => $startPos - 1 - ($closing_tag ? 1 : 0),
                            'end' => $startPos
                            );
                            $state = self::PARSER_TEXT;
                        }
                    } else {
                        $tagName = strtolower(substr($text, $startPos, $tagOptStartPos - $startPos));

                        if (!$this->isValidTag($tagName, true)) {
                            $tmpData = array(
                            'start' => $startPos - 1,
                            'end' => $startPos
                            );
                            $state = self::PARSER_TEXT;
                            break;
                        }

                        $delimiter = $text{$tagOptStartPos + 1};
                        if ($delimiter == '&' && substr($text, $tagOptStartPos + 2, 5) == 'quot;') {
                            $delimiter = '&quot;';
                            $delim_len = 7;
                        } else if ($delimiter != '"' && $delimiter != "'") {
                            $delimiter = '';
                            $delim_len = 1;
                        } else {
                            $delim_len = 2;
                        }

                        if ($delimiter != '') {
                            $close_delim = strpos($text, $delimiter . ']', $tagOptStartPos + $delim_len);
                            if ($close_delim === false) {
                                $delimiter = '';
                                $delim_len = 1;
                            } else {
                                $tagClosePos = $close_delim;
                            }
                        }

                        $tagOption = substr($text, $tagOptStartPos + $delim_len, $tagClosePos - ($tagOptStartPos + $delim_len));
                        if ($this->isValidTag($tagName, false, $tagOption)) {
                            $output[] = array(
                            'type' => 'tag',
                            'name' => $tagName,
                            'option' => $tagOption,
                            'delimiter' => $delimiter,
                            'closing' => false
                            );

                            $startPos = $tagClosePos + $delim_len;
                            $state = self::PARSER_START;
                        } else {
                            $tmpData = array(
                            'start' => $startPos - 1,
                            'end' => $startPos
                            );
                            $state = self::PARSER_TEXT;
                        }
                    }
                    break;
            }
        }

        return $output;
    }

    /**
     * Исправляет вложенные и незакрытые bb-коды
     *
     * @param array $preparsed
     * @return array
     */
    protected function prepareTags($preparsed)
    {
        $output = array();
        $stack = array();
        $noparse = null;

        foreach ($preparsed as $node_key => $node) {
            if ($node['type'] == 'text') {
                $output[] = $node;
            } elseif ($node['closing'] == false) {
                if ($noparse !== null) {
                    $output[] = array(
                    'type' => 'text',
                    'data' => '[' . $node['name'] . (($node['option']) ? '=' . $node['delimiter'] . $node['option'] . $node['delimiter'] : '') . ']'
                    );
                    continue;
                }

                $output[] = $node;
                end($output);

                $node['added_list'] = array();
                $node['my_key'] = key($output);
                array_unshift($stack, $node);

                if ($node['name'] == 'noparse') {
                    $noparse = $node_key;
                }
            } else {
                if ($noparse !== null && $node['name'] != 'noparse') {
                    $output[] = array(
                    'type' => 'text',
                    'data' => '[/' . $node['name'] . ']'
                    );
                } else if (($key = $this->findFirstTag($node['name'], $stack)) !== false) {
                    if ($node['name'] == 'noparse') {
                        if ($key != 0) {
                            for ($i = 0; $i < $key; $i++) {
                                $output[] = $stack[$i];
                                unset($stack[$i]);
                            }
                        }

                        $output[] = $node;

                        unset($stack[$key]);
                        $stack = array_values($stack);
                        $noparse = null;

                        continue;
                    }

                    if ($key != 0) {
                        end($output);
                        $max_key = key($output);

                        for ($i = 0; $i < $key; $i++) {
                            $output[] = array(
                            'type' => 'tag',
                            'name' => $stack[$i]['name'],
                            'closing' => true
                            );
                            $max_key++;
                            $stack[$i]['added_list'][] = $max_key;
                        }
                    }

                    $output[] = $node;

                    if ($key != 0) {
                        $max_key++;
                        for ($i = $key - 1; $i >= 0; $i--) {
                            $output[] = $stack[$i];
                            $max_key++;
                            $stack[$i]['added_list'][] = $max_key;
                        }
                    }

                    unset($stack[$key]);
                    $stack = array_values($stack);
                } else {
                    $output[] = array(
                    'type' => 'text',
                    'data' => '[/' . $node['name'] . ']'
                    );
                }
            }
        }

        foreach ($stack as $open)
        {
            foreach ($open['added_list'] AS $node_key) {
                unset($output[$node_key]);
            }
            $output[$open['my_key']] = array(
            'type' => 'text',
            'data' => '[' . $open['name'] . (!empty($open['option']) ? '=' . $open['delimiter'] . $open['option'] . $open['delimiter'] : '') . ']'
            );
        }

        return $output;
    }

    /**
     * Собирает из массива HTML-код
     *
     * @param array $preparsed
     * @return string конечный результат
     */
    protected function parseArray($preparsed)
    {
        $output = '';

        $stack = array();
        $stack_size = 0;

        $node_max = count($preparsed);
        $current = null;
        $node_num = 0;
        $no_wordwrap = 0;
        $no_smileys = 0;

        foreach ($preparsed as $node) {
            $pending = null;
            $node_num++;

            if ($node['type'] == 'text') {
                $pending =& $node['data'];
                $pending = $no_wordwrap == 0 ? $this->wordwrap($pending) : $pending;

                if ($no_smileys == 0) {
                    $pending = $this->parseSmileys($pending);
                }

            } elseif ($node['closing'] == false) {
                $node['data'] = '';
                array_unshift($stack, $node);
                ++$stack_size;
                $tag = &$this->tags[$node['name']];
                if (!empty($tag['no_wordwrap'])) {
                    $no_wordwrap++;
                }
                if (!empty($tag['no_smileys'])) {
                    $no_smileys++;
                }
            } else {
                if (($key = $this->findFirstTag($node['name'], $stack)) !== false) {
                    $open = &$stack[$key];
                    $current = &$open;

                    if (isset($this->tags[$open['name']])) {
                        $tag = &$this->tags[$open['name']];

                        if (isset($tag['callback'])) {
                            $pending = $this->$tag['callback']($open['data'], $open['option']);
                        } else {
                            if (trim($open['data'])) {
                                $pending = sprintf($tag['html'], $open['data'], $open['option']);
                            }
                        }

                        if (!empty($tag['no_wordwrap'])) {
                            $no_wordwrap--;
                        }
                        if (!empty($tag['no_smileys'])) {
                            $no_smileys--;
                        }
                    } else {
                        $pending = '&#91;' . $open['name'] . (($open['option'] && $open['option'] != '') ? '=' . $open['delimiter'] . $open['option'] . $open['delimiter'] : '') . '&#93;';
                    }
                    unset($stack[$key]);
                    --$stack_size;
                    $stack = array_values($stack);
                } else {
                    $pending = '&#91;/' . $node['name'] . '&#93;';
                }
            }

            if ($stack_size == 0) {
                $output .= $pending;
            } else {
                $stack[0]['data'] .= $pending;
            }
        }

        return $output;
    }

    /**
     * Поиск первого тега bb-кода
     *
     * @param string $tag имя bb-кода
     * @param array $stack
     * @return string|false
     */
    protected function findFirstTag($tag, &$stack)
    {
        foreach ($stack as $key => $node) {
            if ($node['name'] == $tag) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Проверяет существует ли такой bb-код
     *
     * @param string $tag
     * @param boolean $isClosed
     * @param boolean $option
     * @return boolean
     */
    protected function isValidTag($tag, $isClosed = false, $option = false)
    {
        if ($tag) {
            if (isset($this->tags[$tag])) {
                if ($isClosed) {
                    return true;
                }

                if (isset($this->tags[$tag]['permanentWithAttributes']) && $this->tags[$tag]['permanentWithAttributes']) {
                    if ($option) {
                        if (isset($this->tags[$tag]['attributes']) && is_array($this->tags[$tag]['attributes'])) {
                            return in_array($option, $this->tags[$tag]['attributes']);
                        }
                    }
                    return false;
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Заменяет текстовые смайлы на HTML-картинки
     *
     * @param string $content
     * @return string
     */
    protected function parseSmileys($content)
    {
        if (!$this->smileys_cache) {
            $this->buildSmileys();
        }
        return str_replace(array_keys($this->smileys), $this->smileys_cache, $content);
    }

    /**
     * Заменяет HTML-картинки смайлов на их текстовый эквивалент
     *
     * @param string $content
     * @return string
     */
    protected function removeSmileys($content)
    {
        if (!$this->smileys_cache) {
            $this->buildSmileys();
        }
        return str_replace($this->smileys_cache, array_keys($this->smileys), $content);
    }

    /**
     * Обработчик для [url=$link]$text[/url]
     *
     * @param string $text
     * @param string $link
     * @return string
     */
    protected function handleUrl($text, $link)
    {
        $link = trim($this->removeSmileys($link));
        $text = trim($this->removeSmileys($text));

        if (empty($link)) {
            $link = $text;
        }

        $link = str_replace(array('`', '"', "'", '['), array('&#96;', '&quot;', '&#39;', '&#91;'), $link);

        $link = str_replace('  ', '', $link);
        $text = str_replace('  ', '', $text);

        if (!strpos($link, ':') && strpos($link, '@')) {
            $link = 'mailto:' . $link;
        } elseif (!preg_match('#^[\d\w]+(?<!about|javascript|vbscript|data):#si', $link)) {
            $link = "http://" . $link;
        }

        if (!$link || $text == $link) {
            $tmp = htmlspecialchars_decode($link);
            if (strlen($tmp) > 60) {
                $text = $this->htmlspecialchars(substr($tmp, 0, 30) . '...' . substr($tmp, -15));
            }
        }

        return sprintf('<a href="%1$s" target="_blank">%2$s</a>', $link, $text);
    }

    public function htmlspecialchars($text)
    {
        return str_replace(array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'),
            preg_replace('/&(?!#[0-9]+|shy;)/si', '&amp;', $text)
        );
    }

    /**
     * Обработчик для [img=$link]$alt[/img]
     *
     * @param string $link
     * @param string $alt
     * @return string
     */
    protected function handleImg($link, $alt = '')
    {
        $link = $this->removeSmileys($link);
        if (preg_match('#^(https?://([^*\r\n]+|[a-z\d/\\._\- !]+))$#i', $link)) {
            $link = str_replace(array('  ', '"'), '', $link);
            $alt = str_replace('"', '', $alt);
            if (empty($alt)) {
                $alt = $link;
            }
            return sprintf('<img src="%1$s" alt="%2$s" title="%2$s" />', $link, $alt);
        }
    }

    /**
     * Обработчик для [quote=$user]$message[/quote]
     *
     * @param string $message
     * @param string $user
     * @return string
     */
    protected function handleQuote($message, $author = '')
    {
        $wrote = i18n::getMessage('quote_wrote', 'simple');

        $html = '<div class="quote">';
        if (!empty($author)) {
            $html .= '<div class="quoteAuthor">' . $author . ' ' . $wrote . ':</div>';
        }

        return $html . trim($message) . '</div>';
    }

    /**
     * Обработчик для [code]$code[/code]
     *
     * @param string $code
     * @return string
     */
    protected function handleCode($code)
    {
        $code = str_replace(array('<br>', '<br />'), '', $code);

        return '<pre class="code">' . $code . '</pre>';
    }

    /**
     * Разделяет текст на необходимое количество строк с использованием разделителя
     *
     * @param string $text
     * @param integer $limit максимальная длина строки
     * @param string $wraptext разделитель строк
     * @return string
     */
    protected function wordwrap($text, $limit = 40, $wraptext = '  ')
    {
        // it's a temporary fix for a case when html is allowed (why it's needed?)
        $text = str_replace('&amp;nbsp;', ' ', $text);

        $regex = '#((?>[^\s&/<>"\\-\[\]]|&[\#a-z0-9]{1,7};){' . $limit . '})(?=[^\s&/<>"\\-\[\]]|&[\#a-z0-9]{1,7};)#iu';
        $limit = (int)$limit;

        if ($limit > 0 && !empty($text)) {
            return preg_replace($regex, '$0' . $wraptext, $text);
        } else {
            return $text;
        }
    }

    /**
     * Конвертирует смайлы в HTML-тег <img>, готовые для замены текстовых смайлов
     *
     */
    protected function buildSmileys()
    {
        $this->smileys_cache = array();
        $html = '<img src="' . SITE_PATH . '/templates/images/smileys/%1$s.gif" alt="%2$s" />';
        foreach ($this->smileys as $smiley => $image) {
            $this->smileys_cache[] =  sprintf($html, $image, $smiley);
        }
    }
}
?>