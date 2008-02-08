<?php

class bbcode
{
    const BB_PARSER_START = 1;

    const BB_PARSER_TEXT = 2;

    const BB_PARSER_TAG_OPENED = 3;

    protected $tags = array(
        'b' => array(
                'html' => '<strong>%1$s</strong>',
                'strip_empty' => true,
            ),
        'i' => array(
                'html' => '<em>%1$s</em>',
                'strip_empty' => true,
            ),
        'u' => array(
                'html' => '<span style="text-decoration: underline;">%1$s</span>',
                'strip_empty' => true,
            ),
        'color' => array(
                'html' => '<font color="%2$s">%1$s</font>',
                'strip_empty' => true,
                'withAttributes' => true,
                'attributes' => array('red', 'blue', 'green')
            ),
        'size' => array(
                'html' => '<font size="%2$s">%1$s</font>',
                'strip_empty' => true,
                'withAttributes' => true,
                'attributes' => array('+1', '+2', '+3')
            ),
        'quote' => array(
                'html' => '<span>quote:"%2$s" - %1$s</span>',
                'strip_empty' => true,
                'attributes' => array('+1', '+2', '+3')
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

        return $this->parse_array($this->fixTags($this->buildBBData($this->content)));
    }

    protected function buildBBData($text)
    {
        $startPos = 0;
        $strlen = strlen($text);
        $output = array();
        $tmpData = array();
        $state = self::BB_PARSER_START;

        while ($strlen > $startPos) {
            switch ($state) {
                case self::BB_PARSER_START:
                    $tagOpenPos = strpos($text, '[', $startPos);
                    if ($tagOpenPos === false) {
                        $tmpData = array(
                            'start' => $startPos,
                            'end' => $strlen
                        );
                        $state = self::BB_PARSER_TEXT;
                    } elseif ($tagOpenPos != $startPos) {
                        $tmpData = array(
                            'start' => $startPos,
                            'end' => $tagOpenPos
                        );
                        $state = self::BB_PARSER_TEXT;
                    } else {
                        $startPos = $tagOpenPos + 1;
                        if ($startPos >= $strlen) {
                            $tmpData = array(
                                'start' => $tagOpenPos,
                                'end' => $strlen
                            );
                            $startPos = $tagOpenPos;
                            $state = self::BB_PARSER_TEXT;
                        } else {
                            $state = self::BB_PARSER_TAG_OPENED;
                        }
                    }
                    break;

                case self::BB_PARSER_TEXT:
                    $end = end($output);
                    if ($end['type'] == 'text') {
                        $key = key($output);
                        $output[$key]['data'] .= substr($text, $tmpData['start'], $tmpData['end'] - $tmpData['start']);
                    } else {
                        $output[] = array(
                            'type' => 'text',
                            'data' => substr($text, $tmpData['start'], $tmpData['end'] - $tmpData['start'])
                        );
                    }

                    $startPos = $tmpData['end'];
                    $state = self::BB_PARSER_START;
                    break;

                case self::BB_PARSER_TAG_OPENED:
                    $tagClosePos = strpos($text, ']', $startPos);
                    if ($tagClosePos === false) {
                        $tmpData = array(
                            'start' => $startPos - 1,
                            'end' => $startPos
                        );
                        $state = self::BB_PARSER_TEXT;
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
                            $state = self::BB_PARSER_START;
                        } else {
                            $tmpData = array(
                                'start' => $startPos - 1 - ($closing_tag ? 1 : 0),
                                'end' => $startPos
                            );
                            $state = self::BB_PARSER_TEXT;
                        }
                    } else {
                        $tagName = strtolower(substr($text, $startPos, $tagOptStartPos - $startPos));

                        if (!$this->isValidTag($tagName, true)) {
                            $tmpData = array(
                                'start' => $startPos - 1,
                                'end' => $startPos
                            );
                            $state = self::BB_PARSER_TEXT;
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
                            $close_delim = strpos($text, "$delimiter]", $tagOptStartPos + $delim_len);
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
                            $state = self::BB_PARSER_START;
                        } else {
                            $tmpData = array(
                                'start' => $startPos - 1,
                                'end' => $startPos
                            );
                            $state = self::BB_PARSER_TEXT;
                        }
                    }
                    break;
            }
        }

        return $output;
    }

    function fixTags($preparsed)
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
                        'data' => '[' . $node['name'] . ($node['option'] !== false ? "=$node[delimiter]$node[option]$node[delimiter]" : '') . ']'
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
                    $output[] = array('type' => 'text', 'data' => '[/' . $node['name'] . ']');
                } else if (($key = $this->findFirstTag($node['name'], $stack)) !== false) {
                    if ($node['name'] == 'noparse') {
                        if ($key != 0) {
                            for ($i = 0; $i < $key; $i++) {
                                $output[] = $stack["$i"];
                                unset($stack["$i"]);
                            }
                        }

                        $output[] = $node;

                        unset($stack["$key"]);
                        $stack = array_values($stack);

                        $noparse = null;

                        continue;
                    }

                    if ($key != 0) {
                        end($output);
                        $max_key = key($output);

                        for ($i = 0; $i < $key; $i++) {
                            $output[] = array('type' => 'tag', 'name' => $stack[$i]['name'], 'closing' => true);
                            $max_key++;
                            $stack[$i]['added_list'][] = $max_key;
                        }
                    }

                    $output[] = $node;

                    if ($key != 0) {
                        $max_key++;
                        for ($i = $key - 1; $i >= 0; $i--)
                        {
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

        foreach ($stack AS $open)
        {
            foreach ($open['added_list'] AS $node_key) {
                unset($output["$node_key"]);
            }
            $output["$open[my_key]"] = array(
                'type' => 'text',
                'data' => '[' . $open['name'] . (!empty($open['option']) ? '=' . $open['delimiter'] . $open['option'] . $open['delimiter'] : '') . ']'
            );
        }

        return $output;
    }

    function parse_array($preparsed, $do_smilies = false, $do_html = false)
    {
        $output = '';

        $this->stack = array();
        $stack_size = 0;

        $this->node_max = count($preparsed);
        $this->node_cur = 0;

        foreach ($preparsed AS $node) {
            $this->node_num++;
            $pending_text = null;

            if ($node['type'] == 'text') {
                $pending_text =& $node['data'];
            } elseif ($node['closing'] == false) {
                $node['data'] = '';
                array_unshift($this->stack, $node);
                ++$stack_size;

                $has_option = $node['option'] !== false ? 'option' : 'no_option';
                $tag_info =& $this->tags[$has_option][$node['name']];
            } else {
                if (($key = $this->findFirstTag($node['name'], $this->stack)) !== false) {
                    $open =& $this->stack[$key];
                    $this->current_tag =& $open;

                    if (isset($this->tags[$open['name']])) {
                        $tag_info =& $this->tags[$open['name']];
                        if ((isset($tag_info['strip_empty']) && $tag_info['strip_empty'] == false) || trim($open['data']) != '') {
                            if (empty($tag_info['data_regex']) || preg_match($tag_info['data_regex'], $open['data'])) {
                                if (!empty($tag_info['parse_option']) && strpos($open['option'], '[') !== false) {
                                    $old_stack = $this->stack;
                                    $open['option'] = $this->parse_bbcode($open['option'], $do_smilies);
                                    $this->stack = $old_stack;
                                    unset($old_stack);
                                }

                                if (isset($tag_info['html'])) {
                                    $pending_text = sprintf($tag_info['html'], $open['data'], $open['option']);
                                } else if (isset($tag_info['callback'])) {
                                    $pending_text = $this->$tag_info['callback']($open['data'], $open['option']);
                                }
                            } else {
                                $pending_text =
                                    '&#91;' . $open['name'] .
                                    ($open['option'] !== false ? "=$open[delimiter]$open[option]$open[delimiter]" : '') .
                                    '&#93;' . $open['data'] . '&#91;/' . $node['name'] . '&#93;'
                                ;
                            }
                        }
                    } else {
                        $pending_text = '&#91;' . $open['name'] . (($open['option'] !== false && $open['option'] != '') ? '=' . $open['delimiter'] . $open['option'] . $open['delimiter'] : '') . '&#93;';
                    }
                    unset($this->stack["$key"]);
                    --$stack_size;
                    $this->stack = array_values($this->stack);
                } else {
                    $pending_text = '&#91;/' . $node['name'] . '&#93;';
                }
            }


            if ($stack_size == 0) {
                $output .= $pending_text;
            } else {
                $this->stack[0]['data'] .= $pending_text;
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

                if (isset($this->tags[$tag]['withAttributes']) && $this->tags[$tag]['withAttributes']) {
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
}
?>