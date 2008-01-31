<?php

class bbcode
{
    protected $bbcodes = array(
        'b' => array(
                    'tag' => 'strong',
                    'attributes' => array()
                ),
        'i' => array(
                    'tag' => 'em',
                    'attributes' => array()
                ),
        'u' => array(
                    'tag' => 'span style="text-decoration:underline;"',
                    'attributes' => array()
                ),
        'font' => array(
                    'tag' => 'font',
                    'attributes' => array(
                                    'size' => array(
                                                '+1', '+2', '+3', '+4'
                                              ),
                                    'font-family' => array(
                                              'Verdana', 'Tahoma'
                                              )
                                )
                ),
    );

    public function __construct($content = null)
    {
        if ($content) {
            $this->content = $content;
        }
    }

    public function parse()
    {
        $content = htmlspecialchars($this->content);
        $patterns = array();
        foreach ($this->bbcodes as $key => $bb) {
            $patterns[] = '!\[(' . $key .')([^\]]*)\](.*)\[/(' . $key .')\]!Uiu';
        }

        $content = preg_replace_callback($patterns, array('self', 'parseTag'), $content);
        //echo htmlspecialchars($content) . '<br />';

        return $content;
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