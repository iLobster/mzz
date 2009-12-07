<?php
/**
 * подсветка для кода: <!-- тип code номер -->
 * для inline-кода: <<code тип>>код<</code>>
 * Имеются следующие типы: apache, bash, css, html, ini, javascript, mysql, php, smarty, sql, xml
 * для отображения html-примеров: <<example>><strong>пример</strong><</example>>
 *
 * новый подраздел:
 * == name.Название
 */

class documentation
{

    protected $chapters = array();

    public function __construct($chapters_file)
    {
        $previous = array();
        $chapters_source = file($chapters_file);

        foreach ($chapters_source as $chapter) {
            $chapter = str_replace("\t", "    ", $chapter);
            $level = substr_count($chapter, "    ");
            $chapter = trim($chapter);

            if ($level !== false && $level >= 0) {
                $previous[$level] = $chapter;
            }

            if ($level === 0) {
                $this->chapters[] = $chapter;
            } elseif ($level === 1) {
                $this->convertToArray($previous[0], $this->chapters);
                $this->chapters[$previous[0]][] = $chapter;
            } elseif ($level === 2) {
                $this->convertToArray($previous[1], $this->chapters[$previous[0]]);
                $this->chapters[$previous[0]][$previous[1]][] = $chapter;
            }
        }
    }

    public function getChapters()
    {
        return $this->chapters;
    }

    private function convertToArray($value, &$chapters)
    {
        if (array_key_exists($value, $chapters)) {
            return;
        }
        $name = $chapters[$key = array_search($value, $chapters)];
        unset($chapters[$key]);
        $chapters[$name] = array();
    }

    public function generateHtmlChapters($chapters = null)
    {
        $html = '<ul>';

        if ($chapters === null) {
            $chapters = $this->chapters;
        }

        foreach ($chapters as $name => $chapter) {
        $html .= '<li>';
            if (is_array($chapter)) {
            $chapter_name = $this->splitChapterString($name);
            $html .= $this->generateHtmlChapters($chapter);
            $html .= $chapter_name;
            } else {

            $chapter_name = $this->splitChapterString($chapter);
            $html .=  $chapter_name ;
            }
            $html .= '</li>';
        }

        return $html . '</ul>';
    }

    private function splitChapterString($chapter_name)
    {
        $names = array();
        $chapter_name =  explode('.', $chapter_name);
        $names['name'] = $chapter_name[0];
        $names['title'] = $chapter_name[1];
        return $names;
    }

}

$documentation = new documentation('ru.txt');


$menu = $documentation->getChapters();

function render($id, $num = null) {
    $path = 'docs/' . $id . '.php';
    if(!file_exists($path)) {
        exit;
    }

    $note = "\r\n<p class=\"note\">";
    $end = "\r\n</p>\r\n";
    $example = "\r\n<div class=\"example\">";
    $end_example = "\r\n</div>\r\n";

    $content = file_get_contents($path);
    $content = preg_replace("/<!--\s*(.*?)?-?code\s*(\d+)\s*-->/ie", 'include_code("' . $id . '-$2", "$1");', $content);
    $content = preg_replace("/<<code\s*(.*?)>>(.*?)<<\/code>>/ise", "highlightInlineCode('$1', str_replace('\\\"', '\"', html_entity_decode('$2')));", $content);

    $content = str_replace(array("<<pre>>", "<</pre>>"), array("<!-- code start here -->\n<div class=\"code\"><div class=\"code_border\">\n<pre>\n", "\n</pre>\n</div></div>\n<!-- code end here -->\n"), $content);

    $content = str_replace(array('<<note>>', '<</note>>'), array($note, $end), $content);
    $content = str_replace(array('<<example>>', '<</example>>'), array($example, $end_example), $content);

    // обрисовка дерева
    $content = str_replace(array('<<c1>>', '<</c1>>'), array('<strong class="red">', '</strong>'), $content);
    $content = str_replace(array('<<c2>>', '<</c2>>'), array('<strong class="blue">', '</strong>'), $content);
    $content = str_replace(array('<<c3>>', '<</c3>>'), array('<strong class="orange">', '</strong>'), $content);
    $content = str_replace(array('<<c4>>', '<</c4>>'), array('<strong class="green">', '</strong>'), $content);

    $content = preg_replace_callback('/^== ([a-z0-9_-]+)\.(.*?)$/im', create_function('$matches', 'return replace_chapter($matches, "' . $id . '", "' . $num . '");'), $content);
    return $content;
}

function replace_chapter($matches, $id, $num)
{
    static $i = 0;
    $i++;
    return '<h4><a name="' . $id . '.' . $matches[1] . '"></a><span class="titleNumber">' . $num . '.' . $i . '.</span> ' . $matches[2] . '</h4>';
}

function include_code($id, $type) {
    $path = 'codes/' . $id . '.php';
    $type = trim($type);
    if(!file_exists($path)) {
        //echo "<font color=red>[code for '$id' doesn't exists]</font>";
        file_put_contents($path, "[code for '$id']");
    }
    if (empty($type)) {
        // return '<div class="code"><div class="code_border">' . highlight_file($path, 1) . '</div></div>';
    }
    include_once 'highlighter/geshi.php';
    if ($type == 'html') { $type = 'html4strict'; }
    $geshi = new GeSHi(file_get_contents($path), $type);
    $geshi->set_encoding("utf-8");
    $geshi->enable_keyword_links(false);
    return '<div class="code"><div class="code_border">' . $geshi->parse_code() . '</div></div>';
}

function highlightInlineCode($type, $code) {
    $type = trim($type);
    $code = trim($code);

    include_once 'highlighter/geshi.php';
    if ($type == 'html') { $type = 'html4strict'; }
    $geshi = new GeSHi($code, $type);
    $geshi->set_encoding("utf-8");
    $geshi->enable_keyword_links(false);
    return '<div class="code"><div class="code_border">' . $geshi->parse_code() . '</div></div>';
}


function checkFile($num) {
    if(!file_exists('docs/' . $num . '.php') || filesize('docs/' . $num . '.php') < 6) {
        touch('docs/' . $num . '.php');
        return '<strong>?</strong>';
    } else {
        return '';
    }
}

function getPaths($array, $path = '', $num = '') {
    $values = array();
    $i = 1;

    foreach ($array as $key => $value) {
        $meta = explode('.', $key, 2);
        $link = trim($meta[0]);
        $n = (empty($num)) ? $i : $num . '.' . $i;

        $p = (empty($path)) ? $link : $path . '.' . $link;
        if(is_array($value)) {
            $values[$p] = array($key, $n, trim($meta[1]));
            $values = $values + getPaths($value, $p, $n);
        } else {
            $meta = explode('.', $value, 2);
            $link = trim($meta[0]);
            $p = (empty($path)) ? $link : $path . '.' . $link;
            $values[$p] = array($value, $n, trim($meta[1]));
        }
        $i++;
    }

    return $values;
}

$isOnePage = isset($_REQUEST['cat']) && $_REQUEST['cat'] == 'one-page';
if (!isset($_REQUEST['cat']) && !$isOnePage) {
    require_once('header.php');
    echo '<div id="onePageLink"><a href="one-page.html">Всё на одной странице</a></div>';

    echo '<h2>Содержание</h2><div id="sectionList"><dl id="fullContent">';
    $i = 1;
    // Все категории
    foreach ($menu as $meta => $items) {
        $meta = explode('.', $meta, 2);
        $title = trim($meta[1]);
        $link = trim($meta[0]);

        //echo '<dt>' . $i . '. <a href="' . $link . '.html">' . $title . "</a></dt>\n";
        echo '<dt><span class="sectionNumber">' . $i . '.</span> ' . $title . '</dt>';
        echo "\n";

        $n = 1;
        // Все подкатегории
        echo '<dd><dl>';
        foreach ($items as $submeta => $subitem) {
            $num =  $n;
            if (is_array($subitem)) {

                $submeta = explode('.', $submeta, 2);
                $subtitle = trim($submeta[1]);
                $sublink = $link . '.' .trim($submeta[0]);

                $m = 'A';
                echo '<dt><span class="sectionNumber">' . $num . '.</span> <a href="' . $sublink . '.html">' . $subtitle . "</a></dt>\n";
                /*echo '<dd><dl>';
                // Разделы в подкатегориях
                foreach ($subitem as $subsubmeta) {
                    $num = $m;

                    $subsubmeta = explode('.', $subsubmeta, 2);
                    $subsubtitle = trim($subsubmeta[1]);

                    $subsublink = $sublink . '.' .trim($subsubmeta[0]);

                    echo '<dt><span class="sectionNumber">' . $num . '.</span> <a href="' . $sublink . '.html#' . $subsublink .'">';
                    echo $subsubtitle . "</a> " . checkFile($subsublink) . "</dt>\n";

                    $m++;
                }
                echo '</dl></dd>';*/

                // Разделы в подкатегориях
                foreach ($subitem as $subsubmeta) {
                    $subsubmeta = explode('.', $subsubmeta, 2);
                    $subsublink = $sublink . '.' .trim($subsubmeta[0]);
                    checkFile($subsublink);
                }

            } else {
                $subitem = explode('.', $subitem, 2);
                $subtitle = trim($subitem[1]);
                $sublink = $link . '.' .trim($subitem[0]);

                echo '<dt><span class="sectionNumber">' . $num . '.</span> <a href="' . $sublink . '.html">' . $subtitle . "</a>" . checkFile($sublink) . "</dt>\n";
            }
            $n++;

        }
        echo '</dl></dd>';

        $i++;
    }
    echo "</dl></div>\n";
    echo '<div class="copyright_f">&nbsp;</div>';
} elseif ($isOnePage) {
    require_once('header.php');
    // @todo возможно надо сделать полноценное дерево
    echo '<div id="sidebarOpener" onmouseover="showSidebar();" onmouseout="hideSidebar();">Разделы</div>';
    echo '<div id="sidebar" onmouseout="hideSidebar();" onmouseover="showSidebar();">';
    echo '<ul class="itemsList">';
    $i = 1;
    // Все категории
    foreach ($menu as $meta => $items) {
        $meta = explode('.', $meta, 2);
        $title = trim($meta[1]);
        $link = trim($meta[0]);

        echo '<li>' . $i . '. <a href="#' . $link . '">' . $title . "</a>\n";

        $n = 1;
        // Все подкатегории

        echo '<ul>';
        foreach ($items as $submeta => $subitem) {
            $num = $i . '.' . $n;
            $subitem = explode('.', is_array($subitem) ? $submeta : $subitem, 2);
            $subtitle = trim($subitem[1]);
            $sublink = $link . '.' .trim($subitem[0]);
            echo '<li>' . $num . '. <a href="#' . $sublink . '">' . $subtitle . "</a></li>\n";
            $n++;

        }
        echo '</ul></li>';
        $i++;
    }
    echo "</ul>\n";
    echo '</div>';

    $paths = $menu;
    $catNum = 1;
    foreach ($paths as $cat => $path) {

        if (is_array($path)) {
            $cat = explode('.', $cat, 2);
            if ($catNum > 1) {
                echo '<p style="padding-bottom: 30px;">&nbsp;</p>';
            }
            echo '<h2><a name="' . $cat[0] . '"></a><span class="titleNumber">Часть ' . $catNum .'.</span> ' . $cat[1] . '</h2>';

            $cat = $cat[0];
            $subCatNum = 0;
            foreach ($path as $subcat => $subpath) {
                $subCatNum++;

                $subcat = explode('.', (is_array($subpath) ? $subcat : $subpath), 2);
                echo '<h3><a name="' . $cat . '.' . $subcat[0] . '"></a><span class="titleNumber">' . $catNum .'.' . $subCatNum .'.</span> ' . $subcat[1] . '</h3>';

                if (is_array($subpath)) {
                    $subSubCatNum = 0;
                    foreach ($subpath as $subsubpath) {
                        $subSubCatNum++;
                        $subsubcat = explode('.', $subsubpath, 2);
                        $subsubcatTitle = $subsubcat[1];
                        $subsubcat = $cat . '.' . $subcat[0] . '.' . $subsubcat[0];
                        echo '<h4><a name="' . $subsubcat . '"></a><span class="titleNumber">' . $catNum .'.' . $subCatNum .'.' . $subSubCatNum .'.</span> ' . $subsubcatTitle . '</h4>';
                        echo render($subsubcat);
                    }
                } else {
                    $subcat = $cat . '.' . $subcat[0];
                    echo render($subcat);
                }

            }


        } else {
            echo render($cat);
        }
        $catNum++;
    }

    echo '<div class="navigation_f">';
    echo '<a href="index.html">Постраничная версия</a>';
    echo '</div>';

} else {
    $cat = explode(".", $_REQUEST["cat"]);
    $paths = getPaths($menu);
    $tmp = $paths;

    // Очищаем от разделов в субкатегориях
    foreach($tmp as $path => $title) {
        $items = explode(".", $path);
        if(count($items) > 2) {
            unset($tmp[$path]);
        }
    }

    $prev = false;

    $break = false;
    foreach($tmp as $path => $title) {
        if($break) {
            break;
        }
        if($path == $_REQUEST["cat"]) {
            $break = true;
        } else {
            $prev = $path;
        }
    }

    if (isset($paths[$_REQUEST['cat']])) {
        $cat_id = '';
        $title = array();
        foreach ($cat as $cat_id_cur) {
            $cat_id .= $cat_id_cur;
            $title[] = $paths[$cat_id][2];
            $cat_id .= '.';
        }
        $title = implode(' | ', array_reverse($title));
    } else {
        // пробуем еще раз (для регистронезависимой WINDOWS)
        if(PHP_OS == 'WINNT' && isset($_SERVER['REQUEST_URI'])) {
            $pos = strrpos($_SERVER['REQUEST_URI'], '/') + 1;
            $_REQUEST['cat'] = substr($_SERVER['REQUEST_URI'], $pos, strrpos($_SERVER['REQUEST_URI'], '.') - $pos);
            if (isset($paths[$_REQUEST['cat']])) {
                $cat_id = '';
                $title = array();
                foreach ($cat as $cat_id_cur) {
                    $cat_id .= $cat_id_cur;
                    $title[] = $paths[$cat_id][2];
                    $cat_id .= '.';
                }
                $title = implode(' | ', array_reverse($title));
            } else {
                $title = '404';
                include('header.php');
                exit('Этот раздел больше не существует в <a href="index.html">документации</a>.');
            }
        } else {
            $title = '404';
            include('header.php');
            exit('Этот раздел больше не существует в <a href="index.html">документации</a>.');
        }
    }
    require_once('header.php');
    echo '<div id="sidebarOpener" onmouseover="showSidebar();" onmouseout="hideSidebar();">Разделы</div>'
    .'<div id="sidebar" onmouseout="hideSidebar();" onmouseover="showSidebar();">';

    $paths_nums = explode('.', $paths[$_REQUEST['cat']][1]);
    echo '<a href="index.html">Индекс</a><ul class="itemsList">';
    $i = 1;
    // Все категории
    foreach ($menu as $meta => $items) {
        $meta = explode('.', $meta, 2);
        $title = trim($meta[1]);
        $link = trim($meta[0]);

        echo '<li>' . $i . '. <a href="' . $link . '.html">' . (($paths[$_REQUEST['cat']][1] === (string)$i) ? '<b>' . $title . '</b>': $title) . "</a>\n";

        $n = 1;
        // Все подкатегории

        if ($paths_nums[0] == $i) {
            echo '<ul>';
            foreach ($items as $submeta => $subitem) {
                $num = $i . '.' . $n;
                if (is_array($subitem)) {

                    $submeta = explode('.', $submeta, 2);
                    $subtitle = trim($submeta[1]);
                    $sublink = $link . '.' .trim($submeta[0]);

                    $m = 'a';
                    $isCurrent = $paths[$_REQUEST['cat']][1] === $i . '.' . $n;

                    echo '<li>' . $num . '. <a href="' . $sublink . '.html">' . ($isCurrent ? '<b>' . $subtitle . '</b>': $subtitle) . "</a>\n";

                    if (isset($paths_nums[1]) && $paths_nums[0] == $i && $paths_nums[1] == $n) {
                        echo '<ul>';
                        // Разделы в подкатегориях
                        foreach ($subitem as $subsubmeta) {
                            $num = $m;

                            $subsubmeta = explode('.', $subsubmeta, 2);
                            $subsubtitle = trim($subsubmeta[1]);

                            $subsublink = $sublink . '.' .trim($subsubmeta[0]);

                            echo '<li>' . $num . '. <a href="' . $sublink . '.html#' . $subsublink .'">';
                            echo $subsubtitle . "</a></li>\n";

                            $m++;
                        }
                        echo '</ul>';
                    }
                    echo '</li>';
                } else {
                    $subitem = explode('.', $subitem, 2);
                    $subtitle = trim($subitem[1]);
                    $sublink = $link . '.' .trim($subitem[0]);
                    $isCurrent = $paths[$_REQUEST['cat']][1] == $i . '.' . $n;

                    echo '<li>' . $num . '. <a href="' . $sublink . '.html">' . ($isCurrent ? '<b>' . $subtitle . '</b>': $subtitle) . "</a></li>\n";

                }
                $n++;

            }
            echo '</ul>';
        }
        echo '</li>';

        $i++;
    }
    echo "</ul>\n";
    echo '</div>';

    if (isset($cat[1])) {
        $category = $paths[$cat[0]][0];
        $tmp = $paths[$_REQUEST['cat']][0];

        echo '<h2><a name="' . $_REQUEST['cat'] . '"></a><span class="titleNumber">' . $paths[$_REQUEST['cat']][1] . '</span> ' . $paths[$_REQUEST['cat']][2] . '</h2>';
        if (isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            $i = '1';
            echo "<dl>";
            foreach($menu[$category][$tmp] as $title => $value) {
                $meta = (is_array($value)) ? $title : $value;
                $meta = explode('.', $meta, 2);
                $title = trim($meta[1]);
                $name = $_REQUEST['cat'];
                $linkname = $_REQUEST['cat'] . '.' . trim($meta[0]);

                echo '<dt><span class="titleNumber">' . $i++ . '.</span> <a href="' . $name . '.html#' . $linkname . '">';
                echo $title . "</a>\n";

                if (file_exists($file_path = './docs/' . $linkname . '.php')) {
                    $content = file_get_contents($file_path);
                    preg_match_all('/^== ([a-z0-9_-]+)\.(.*)/im', $content, $matches);
                    if (isset($matches[1])) {
                        foreach ($matches[1] as $k => $subchapter) {

                            echo '<dd><dl><dt><span class="titleNumber">' . ($k + 1) . '.</span> <a href="' . $name . '.html#' . $linkname . '.' . $subchapter .'">';
                            echo $matches[2][$k] . "</a>\n";

                            echo "</dt></dl></dd>\n";
                        }
                    }
                }
                echo "</dt>\n";
            }
            echo "</dl>";
        }


        if(isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            $i = '1';
            foreach ($menu[$category][$tmp] as $key => $title) {
                $meta = explode('.', $title, 2);
                $title = trim($meta[1]);
                $link = trim($meta[0]);
                $id = $_REQUEST['cat'] . '.' . $link;
                $num = $i++;
                echo '<h3><a name="' . $id . '"></a><span class="titleNumber">' . $num . '.</span> ' . $title . '</h3>';
                echo render($id, $i - 1);
            }
        } else {
            echo render($_REQUEST['cat']);
        }

    } else {
        $tmp = $paths[$cat[0]][0];
        $i = 1;

        echo '<h2><span class="titleNumber">' . $paths[$cat[0]][1] . '.</span> ' . $paths[$cat[0]][2] . '</h2>';
        echo "<dl>";
        foreach($menu[$tmp] as $title => $value) {
            $meta = (is_array($value)) ? $title : $value;
            $meta = explode('.', $meta, 2);
            $title = trim($meta[1]);
            $link = trim($meta[0]);


            $num = $i;
            $link = $cat[0] . '.' . $link;

            echo '<dt><span class="titleNumber">' . $num . '.</span> <a href="' . $link . '.html#' . $link . '">';
            echo $title . "</a></dt>\n";
            $i++;
        }
        echo "</dl>";
    }

    echo '<div class="navigation_f">';

    if($prev && $prev != $_REQUEST['cat']) {
        echo '<a href="' . $prev . '.html"><span style="font-size: 120%;">&larr;</span> Назад</a> | ';
    }

    echo '<a href="index.html">Индекс</a>';

    if($path != $_REQUEST['cat']) {
        echo ' | <a href="' . $path . '.html">Вперед <span style="font-size: 120%;">&rarr;</span></a>';
    }

    echo '</div>';
}
?>
</div>
</body>
</html>
