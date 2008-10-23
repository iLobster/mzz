<?php

class bbcode
{
    const PARSER_START = 1;

    const PARSER_TEXT = 2;

    const PARSER_TAG_OPENED = 3;

    protected $smileys = array();

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
    'html' => '<span>quote:"%2$s" - %1$s</span>',
    ),
    'img' => array(
    'html' => '<img src="%1$s" title="%2$s" alt="%2$s" />',
    ),
    'url' => array(
    'callback' => 'handleUrl'
    ),
    );

    public function __construct($content = null)
    {
        if ($content) {
            $this->content = $content;
        }
    }

    public function parse($content = null)
    {
        if ($content) {
            $this->content = $content;
        }

        $result = $this->parseArray($this->prepareTags($this->buildBBData($this->content)));

        $find = array('/(javascript|about|vbscript):/si', '/&(?![a-z0-9#]+;)/si');
        $replace = array('$1<b></b>:', '&amp;');
        $result = preg_replace($find, $replace, $result);

        return $result;
    }

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

    protected function parseArray($preparsed, $do_smilies = false, $do_html = false)
    {
        $output = '';

        $stack = array();
        $stack_size = 0;

        $node_max = count($preparsed);
        $current = null;
        $node_num = 0;

        foreach ($preparsed as $node) {
            $pending = null;
            $node_num++;

            if ($node['type'] == 'text') {
                $pending =& $node['data'];
                $pending = $this->wordwrap($pending);
            } elseif ($node['closing'] == false) {
                $node['data'] = '';
                array_unshift($stack, $node);
                ++$stack_size;

                $tag = &$this->tags[$node['name']];
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

                        /*
                        if (trim($open['data'])) {
                        $pending = sprintf($tag['html'], $open['data'], $open['option']);
                        }*/
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

    protected function findFirstTag($tag, &$stack)
    {
        foreach ($stack as $key => $node) {
            if ($node['name'] == $tag) {
                return $key;
            }
        }

        return false;
    }

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

    protected function parseSmiles($content = null)
    {
        if (!$content) {
            $content = $this->content;
        }

        $smileys = array_keys($this->smileys);
        $pics = array_values($this->smileys);

        return str_replace($smileys, $pics, $content);
    }

    protected function handleUrl($text, $link)
    {
        $link = trim($link);
        $text = trim($text);

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
                $text = htmlspecialchars(substr($tmp, 0, 30) . '...' . substr($tmp, -15));
            }
        }

        return sprintf('<a href="%1$s" target="_blank">%2$s</a>', $link, $text);
    }

    protected function handleQuote($message, $user = '')
    {
        $post = 0;

        if (preg_match('/^(.+)(?<!&#\d{3}|&#\d{4}|&#\d{5});\s*(\d+)\s*$/U', $user, $match)) {
            $user = $match[1];
            $post = $match[2];
        }

        return $html;
    }


    protected function wordwrap($text, $wraptext = '  ', $limit = 40)
    {
        $regex = '#((?>[^\s&/<>"\\-\[\]]|&[\#a-z0-9]{1,7};){' . $limit . '})(?=[^\s&/<>"\\-\[\]]|&[\#a-z0-9]{1,7};)#i';
        $limit = (int)$limit;

        if ($limit > 0 && !empty($text)) {
            return preg_replace($regex, '$0' . $wraptext, $text);
        } else {
            return $text;
        }
    }

}
?>