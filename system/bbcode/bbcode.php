<?php

class bbcode
{
    const BB_PARSER_START = 1;

    const BB_PARSER_TEXT = 2;

    const BB_PARSER_TAG_OPENED = 3;

    protected $tags = array(
        'no_option' => array(
            'b' => array(
                'html' => '<strong>%1$s</strong>',
                'strip_empty' => true
            ),
            'i' => array(
                'html' => '<em>%1$s</em>',
                'strip_empty' => true
            ),
            'u' => array(
                'html' => '<span style="text-decoration: underline;">%1$s</span>',
                'strip_empty' => true
            )
        ),
        'options' => array(
            'font' => array(
                'html' => '<strong>%1$s</strong>',
                'strip_empty' => true
            )
        )
    );

    public function __construct($content = null)
    {
        if ($content) {
            $this->content = $content;
        }
    }

    public function parse()
    {
        return $this->parse_array($this->fixTags($this->buildParseArray($this->content)));

        /*
        $content = htmlspecialchars($this->content);
        $patterns = array();
        foreach ($this->bbcodes as $key => $bb) {
            $patterns[] = '!\[(' . $key .')([^\]]*)\](.*)\[/(' . $key .')\]!Uiu';
        }

        $content = preg_replace_callback($patterns, array('self', 'parseTag'), $content);
        //echo htmlspecialchars($content) . '<br />';

        return $content;
        */
    }



    protected function buildParseArray($text)
	{
		$start_pos = 0;
		$strlen = strlen($text);
		$output = array();
		$state = self::BB_PARSER_START;

		while ($start_pos < $strlen) {
			switch ($state) {
				case self::BB_PARSER_START:
					$tag_open_pos = strpos($text, '[', $start_pos);
					if ($tag_open_pos === false) {
						$internal_data = array('start' => $start_pos, 'end' => $strlen);
						$state = self::BB_PARSER_TEXT;
					} elseif ($tag_open_pos != $start_pos) {
						$internal_data = array('start' => $start_pos, 'end' => $tag_open_pos);
						$state = self::BB_PARSER_TEXT;
					} else {
						$start_pos = $tag_open_pos + 1;
						if ($start_pos >= $strlen) {
							$internal_data = array('start' => $tag_open_pos, 'end' => $strlen);
							$start_pos = $tag_open_pos;
							$state = self::BB_PARSER_TEXT;
						} else {
							$state = self::BB_PARSER_TAG_OPENED;
						}
					}
					break;

				case self::BB_PARSER_TEXT:
					$end = end($output);
					if ($end['type'] == 'text') {
						// our last element was text too, so let's join them
						$key = key($output);
						$output[$key]['data'] .= substr($text, $internal_data['start'], $internal_data['end'] - $internal_data['start']);
					} else {
						$output[] = array('type' => 'text', 'data' => substr($text, $internal_data['start'], $internal_data['end'] - $internal_data['start']));
					}

					$start_pos = $internal_data['end'];
					$state = self::BB_PARSER_START;
					break;

				case self::BB_PARSER_TAG_OPENED:
					$tag_close_pos = strpos($text, ']', $start_pos);
					if ($tag_close_pos === false) {
						$internal_data = array('start' => $start_pos - 1, 'end' => $start_pos);
						$state = self::BB_PARSER_TEXT;
						break;
					}

					// check to see if this is a closing tag, since behavior changes
					$closing_tag = ($text{$start_pos} == '/');
					if ($closing_tag) {
						// we don't want the / to be saved
						++$start_pos;
					}

					// ok, we have a ], check for an option
					$tag_opt_start_pos = strpos($text, '=', $start_pos);
					if ($closing_tag || $tag_opt_start_pos === false || $tag_opt_start_pos > $tag_close_pos) {
						// no option, so the ] is the end of the tag
						// check to see if this tag name is valid
						$tag_name = strtolower(substr($text, $start_pos, $tag_close_pos - $start_pos));

						// if this is a closing tag, we don't know whether we had an option
						$has_option = $closing_tag ? null : false;

						if ($this->isValidTag($tag_name, $has_option)) {
							$output[] = array(
								'type' => 'tag',
								'name' => $tag_name,
								'option' => false,
								'closing' => $closing_tag
							);

							$start_pos = $tag_close_pos + 1;
							$state = self::BB_PARSER_START;
						} else {
							// this is an invalid tag, so it's just text
							$internal_data = array('start' => $start_pos - 1 - ($closing_tag ? 1 : 0), 'end' => $start_pos);
							$state = self::BB_PARSER_TEXT;
						}
					} else {
						// check to see if this tag name is valid
						$tag_name = strtolower(substr($text, $start_pos, $tag_opt_start_pos - $start_pos));

						if (!$this->isValidTag($tag_name, true)) {
							// this isn't a valid tag name, so just consider it text
							$internal_data = array('start' => $start_pos - 1, 'end' => $start_pos);
							$state = self::BB_PARSER_TEXT;
							break;
						}

						// we have a = before a ], so we have an option
						$delimiter = $text{$tag_opt_start_pos + 1};
						if ($delimiter == '&' && substr($text, $tag_opt_start_pos + 2, 5) == 'quot;') {
							$delimiter = '&quot;';
							$delim_len = 7;
						} else if ($delimiter != '"' && $delimiter != "'") {
							$delimiter = '';
							$delim_len = 1;
						} else {
							$delim_len = 2;
						}

						if ($delimiter != '') {
							$close_delim = strpos($text, "$delimiter]", $tag_opt_start_pos + $delim_len);
							if ($close_delim === false) {
								// assume no delimiter, and the delimiter was actually a character
								$delimiter = '';
								$delim_len = 1;
							} else {
								$tag_close_pos = $close_delim;
							}
						}

						$tag_option = substr($text, $tag_opt_start_pos + $delim_len, $tag_close_pos - ($tag_opt_start_pos + $delim_len));
						if ($this->isValidTag($tag_name, $tag_option)) {
							$output[] = array(
								'type' => 'tag',
								'name' => $tag_name,
								'option' => $tag_option,
								'delimiter' => $delimiter,
								'closing' => false
							);

							$start_pos = $tag_close_pos + $delim_len;
							$state = self::BB_PARSER_START;
						} else {
							// this is an invalid option, so consider it just text
							$internal_data = array('start' => $start_pos - 1, 'end' => $start_pos);
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

		foreach ($preparsed as $node_key => $node)
		{
			if ($node['type'] == 'text') {
				$output[] = $node;
			} else if ($node['closing'] == false) {
				if ($noparse !== null) {
					$output[] = array('type' => 'text', 'data' => '[' . $node['name'] . ($node['option'] !== false ? "=$node[delimiter]$node[option]$node[delimiter]" : '') . ']');
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
				// closing tag
				if ($noparse !== null && $node['name'] != 'noparse') {
					// closing a tag but we're in a noparse - treat as text
					$output[] = array('type' => 'text', 'data' => '[/' . $node['name'] . ']');
				} else if (($key = $this->find_first_tag($node['name'], $stack)) !== false) {
					if ($node['name'] == 'noparse') {
						// we're closing a noparse tag that we opened
						if ($key != 0) {
							for ($i = 0; $i < $key; $i++) {
								$output[] = $stack["$i"];
								unset($stack["$i"]);
							}
						}

						$output[] = $node;

						unset($stack["$key"]);
						$stack = array_values($stack); // this is a tricky way to renumber the stack's keys

						$noparse = null;

						continue;
					}

					if ($key != 0) {
						end($output);
						$max_key = key($output);

						// we're trying to close a tag which wasn't the last one to be opened
						// this is bad nesting, so fix it by closing tags early
						for ($i = 0; $i < $key; $i++) {
							$output[] = array('type' => 'tag', 'name' => $stack["$i"]['name'], 'closing' => true);
							$max_key++;
							$stack["$i"]['added_list'][] = $max_key;
						}
					}

					$output[] = $node;

					if ($key != 0) {
						$max_key++; // for the node we just added

						// ...and now reopen those tags in the same order
						for ($i = $key - 1; $i >= 0; $i--)
						{
							$output[] = $stack["$i"];
							$max_key++;
							$stack["$i"]['added_list'][] = $max_key;
						}
					}

					unset($stack["$key"]);
					$stack = array_values($stack); // this is a tricky way to renumber the stack's keys
				} else {
					// we tried to close a tag which wasn't open, to just make this text
					$output[] = array('type' => 'text', 'data' => '[/' . $node['name'] . ']');
				}
			}
		}

		// These tags were never closed, so we want to display the literal BB code.
		// Rremove any nodes we might've added before, thinking this was valid,
		// and make this node become text.
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

		/*
		// automatically close any tags that remain open
		foreach (array_reverse($stack) AS $open)
		{
			$output[] = array('type' => 'tag', name => $open['name'], 'closing' => true);
		}
		*/

		return $output;
	}

	function parse_array($preparsed, $do_smilies = false, $do_html = false)
	{
		$output = '';

		$this->stack = array();
		$stack_size = 0;

		// holds options to disable certain aspects of parsing
		$parse_options = array(
			'no_parse' => 0,
			'no_wordwrap' => 1,
			'no_smilies' => 0,
			'strip_space_after' => 0
		);

		$this->node_max = count($preparsed);
		$this->node_cur = 0;

		foreach ($preparsed AS $node)
		{
			$this->node_num++;

			$pending_text = '';
			if ($node['type'] == 'text') {
				$pending_text =& $node['data'];

				// remove leading space after a tag
				if ($parse_options['strip_space_after']) {
					$pending_text = $this->strip_front_back_whitespace($pending_text, $parse_options['strip_space_after'], true, false);
					$parse_options['strip_space_after'] = 0;
				}

				// do word wrap
				if (!$parse_options['no_wordwrap']) {
					//$pending_text = $this->do_word_wrap($pending_text);
				}

				// parse smilies
				if ($do_smilies && !$parse_options['no_smilies']) {
					$pending_text = $this->parse_smilies($pending_text, $do_html);
				}

				if ($parse_options['no_parse']) {
					$pending_text = str_replace(array('[', ']'), array('&#91;', '&#93;'), $pending_text);
				}
			} else if ($node['closing'] == false) {
				$parse_options['strip_space_after'] = 0;

				if ($parse_options['no_parse'] == 0) {
					// opening a tag
					// initialize data holder and push it onto the stack
					$node['data'] = '';
					array_unshift($this->stack, $node);
					++$stack_size;

					$has_option = $node['option'] !== false ? 'option' : 'no_option';
					$tag_info =& $this->tags["$has_option"]["$node[name]"];

					// setup tag options
					if (!empty($tag_info['stop_parse'])) {
						$parse_options['no_parse'] = 1;
					}
					if (!empty($tag_info['disable_smilies'])) {
						$parse_options['no_smilies']++;
					}
					if (!empty($tag_info['disable_wordwrap'])) {
						$parse_options['no_wordwrap']++;
					}
				} else {
					$pending_text = '&#91;' . $node['name'] . ($node['option'] !== false ? "=$node[delimiter]$node[option]$node[delimiter]" : '') . '&#93;';
				}
			} else {
				$parse_options['strip_space_after'] = 0;

				// closing a tag
				// look for this tag on the stack
				if (($key = $this->find_first_tag($node['name'], $this->stack)) !== false) {
					// found it
					$open =& $this->stack["$key"];
					$this->current_tag =& $open;

					$has_option = $open['option'] !== false ? 'option' : 'no_option';

					// check to see if this version of the tag is valid
					if (isset($this->tags["$has_option"]["$open[name]"])) {
						$tag_info =& $this->tags["$has_option"]["$open[name]"];

						// make sure we have data between the tags
						if ((isset($tag_info['strip_empty']) AND $tag_info['strip_empty'] == false) OR trim($open['data']) != '') {
							// make sure our data matches our pattern if there is one
							if (empty($tag_info['data_regex']) OR preg_match($tag_info['data_regex'], $open['data'])) {
								// see if the option might have a tag, and if it might, run a parser on it
								if (!empty($tag_info['parse_option']) AND strpos($open['option'], '[') !== false) {
									$old_stack = $this->stack;
									$open['option'] = $this->parse_bbcode($open['option'], $do_smilies);
									$this->stack = $old_stack;
									unset($old_stack);
								}

								// now do the actual replacement
								if (isset($tag_info['html'])) {
									// this is a simple HTML replacement
									$pending_text = sprintf($tag_info['html'], $open['data'], $open['option']);
								} else if (isset($tag_info['callback'])) {
									// call a callback function
									$pending_text = $this->$tag_info['callback']($open['data'], $open['option']);
								}
							} else {
								// oh, we didn't match our regex, just print the tag out raw
								$pending_text =
									'&#91;' . $open['name'] .
									($open['option'] !== false ? "=$open[delimiter]$open[option]$open[delimiter]" : '') .
									'&#93;' . $open['data'] . '&#91;/' . $node['name'] . '&#93;'
								;
							}
						}

						// undo effects of various tag options
						if (!empty($tag_info['strip_space_after'])) {
							$parse_options['strip_space_after'] = $tag_info['strip_space_after'];
						}
						if (!empty($tag_info['stop_parse'])) {
							$parse_options['no_parse'] = 0;
						}
						if (!empty($tag_info['disable_smilies'])) {
							$parse_options['no_smilies']--;
						}
						if (!empty($tag_info['disable_wordwrap'])) {
							$parse_options['no_wordwrap']--;
						}
					} else {
						// this tag appears to be invalid, so just print it out as text
						$pending_text = '&#91;' . $open['name'] . ($open['option'] !== false ? "=$open[delimiter]$open[option]$open[delimiter]" : '') . '&#93;';
					}

					// pop the tag off the stack

					unset($this->stack["$key"]);
					--$stack_size;
					$this->stack = array_values($this->stack); // this is a tricky way to renumber the stack's keys
				} else {
					// wasn't there - we tried to close a tag which wasn't open, so just output the text
					$pending_text = '&#91;/' . $node['name'] . '&#93;';
				}
			}


			if ($stack_size == 0) {
				$output .= $pending_text;
			} else {
				$this->stack[0]['data'] .= $pending_text;
			}
		}

		/*
		// check for tags that are stil open at the end and display them
		foreach (array_reverse($this->stack) AS $open)
		{
			$output .= '[' . $open['name'];
			if ($open['option'])
			{
				$output .= '=' . $open['delimiter'] . $open['option'] . $open['delimiter'];
			}
			$output .= "]$open[data]";
			//$output .= $open['data'];
		}
		*/

		return $output;
	}

	function find_first_tag($tag, &$stack)
	{
		foreach ($stack as $key => $node) {
			if ($node['name'] == $tag) {
				return $key;
			}
		}

		return false;
	}

	protected function isValidTag($tag, $option = null)
	{
		if ($tag) {
    		if ($tag[0] == '/') {
    			$tag = substr($tag, 1);
    		}

    		if ($option === null) {
    			return (isset($this->tags['no_option'][$tag]) || isset($this->tags['option'][$tag]));
    		} else {
    			$option = $option ? 'option' : 'no_option';
    			return isset($this->tags[$option][$tag]);
    		}
		}

		return false;
	}

    public function parseTag($matches)
    {
        list($original, $tag, $attributes, $content) = $matches;

        $validatedAttributes = null;

        if ($attributes) {
            if (strpos($attributes, ' ') !== 0) {
                return htmlspecialchars_decode($original);
            }

            $tmpAtr = array();
            foreach ($this->parseAttributes($tag, $attributes) as $key => $value) {
                //если такой аттрибут уже передавался, либо если такой аттрибут запрещен в этом теге, либо если такое значение аттрибута запрещено,
                //то выводить оригинал
                if (isset($tmpAtr[$key]) || !isset($this->bbcodes[$tag]['attributes'][$key]) || !in_array($value, $this->bbcodes[$tag]['attributes'][$key])) {
                    return htmlspecialchars_decode($original);
                }

                $tmpAtr[$key] = $value;
                $validatedAttributes .= $key . '="' . $value . '" ';
            }
            $validatedAttributes = trim($validatedAttributes);
        }

        $tagClose = explode(' ', $this->bbcodes[$tag]['tag']);

        return htmlspecialchars_decode('<' . $this->bbcodes[$tag]['tag'] . ($validatedAttributes ? ' ' . $validatedAttributes : null) .'>' . $content . '</' . $tagClose[0] . '>');
    }

    protected function parseAttributes($tag, $attributes)
    {
        if (preg_match_all('!(.*)="(.*)"!U', htmlspecialchars_decode($attributes), $matches)) {
            $atrs = array();
            for ($i = 0; $i < count($matches[0]); $i++) {
                $key = trim($matches[1][$i]);
                $value = trim($matches[2][$i]);
                $atrs[$key] = $value;
            }

            return $atrs;
        }

        return array();
    }
}
?>