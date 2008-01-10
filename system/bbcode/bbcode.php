<?php
class bbcode
{
    protected $content;

    protected $bbcodes = array(
        'img' => 'img',
        'b' => 'strong',
        'i' => 'i',
    );

    public function __construct($content = null)
    {
        if ($content) {
            $this->content = $content;
        }
    }

    public function parse()
    {
        $content = $this->content;
        $content = preg_replace_callback('!\[(\/?)(' . join('|', array_keys($this->bbcodes)) .')([^\]]*)\]!Uu', array('self', 'parseTag'), $content);
        echo htmlspecialchars($content) . '<br />';
        return $content;
    }

    public function parseTag($matches)
    {
        list($match, $add, $tag, $attributes) = $matches;
        $attributes = trim($attributes);

        return '<' . $add . $this->bbcodes[$tag] . (($add != '/' && !empty($attributes)) ? ' ' .$attributes : null) .'>';
    }
}
?>