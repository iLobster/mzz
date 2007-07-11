<?php
/**
 * ��������� ��� ����: <!-- ��� code ����� -->
 * ��� inline-����: <<code ���>>���<</code>>
 * ��� ����������� html-��������: <<example>><strong>������</strong><</example>>
 * ������� ��������� ����: apache, bash, css, html, ini, javascript, mysql, php, smarty, sql, xml
 *
 */

$menu = array("intro.�����������" =>
                        array(
                        "about.��������",
                        "philosophy.��������� ���",
                        ),
           "setup.��������� � ���������" =>
                        array(
                        "system_requirements.����������� ����������",
                        "server.��������� �� ������",
                        "configuration.������������"
                                => array("system.��������� ������������ �������",
                                         "routes.��������� Routes ��� URL",
                                         "apache.��������� ��� http-������� Apache"),
                        ),
           "structure.��������� mzz" =>
                        array(
                        "templates.�������"
                                => array("about.����� ��������",
                                         "load.������� {load}",
                                         "add.������� {add}",
                                         "url.������� {url}",
                                         ),
                        "classes.�������� ��������� ������"
                                => array("toolkit.������",
                                         "request.Request",
                                         "response.Response",
                                         "routers.Routers",
                                         "resolver.Resolver",
                                         "dataspace.Dataspace",
                                         "frontcontroller.Frontcontroller"
                                         ),
                        "run.������� ������� ����������",
                        "mvc.MVC",
                        //"urls.��������� �����, ��� ����� ����� ������",
                        "orm.ORM",
                        "acl.ACL"
                                => array("overview.�����",
                                         "tables.�������� ���� � ��",
                                         "overlay.��������� ����",
                                         "owners.��������� ��������",
                                         "coding.������ � ACL",
                                         "module_running.������ ������� �� ��������"
                                         ),
                        "folders.��������� ��������� mzz",
                        "files.���������� ��������� ������ (����� �������-���� ���)",
                        "jip.JIP � AJAX",
                        "forms.������� � �����"
                                => array("elements.�������� �������",
                                         "create.�������� ����������� ��������� ����",
                                         "validation.��������� ����",
                                         "create_rule.�������� ����������� �����������"
                                         ),
                        "timer.�������� timer",
                        ),
           "quick_start.������� �����" =>
                        array(
                        "project.��������� �������",
                        "config.�������� ������������ ��� �������",
                        "modules.������������� ����������� �������",
                        "news_extend.���������� ������ News ��� ����������� �������",
                        "code_generation.�������������� ��������� ����",
                        ),
           "modules.������ �������" =>
                        array(
                        "description.�������� ��������� ��������� ������ mzz"
                                => array("folders.��������� ���������",
                                         "actions.Actions",
                                         "controllers.Controllers",
                                         "mappers.Mappers",
                                         "maps.Maps",
                                         ),
                        "simple.������� ������ ��� ��������� �������"
                                => array("simple.simple",
                                         "simpleForTree.simpleForTree",
                                         "simpleMapper.simpleMapper",
                                         "simpleMapperForTree.simpleMapperForTree",
                                         "simpleController.simpleController",
                                         "simpleFactory.simpleFactory",
                                         "403controller.simple403Controller",
                                         "404controller.simple404Controller",
                                         "messageController.messageController"
                                         ),
                        "news.�������� ������ News",
                        "page.�������� ������ Page",
                        'writing_module.��������� ������ "� ����" �� ������� ������ Comments'
                                => array("intro.��������",
                                         "planning.������������",
                                         "db_structure.��������� ��",
                                         "urls.����� ��� �����",
                                         "creating_folders.�������� ��������� ���������",
                                         "creating_do.�������� ���������",
                                         "module_registration.����������� ������ ������ � �������",
                                         "programming.���������������� ��������",
                                         "round_up.���������� ������",
                                         ),
                        "404handling.�������� ��������� ������ 404 � �������",
                        ),
           "acl.������������ � �����" =>
                        array(
                        "users.���������� ��������������",
                        "groups.���������� ��������",
                        "permissions.���������� �������",
                        ),
           "db.������ � ��" =>
                        array(
                        "queries.����������� ��������. ������������� criteria",
                        "tree.������ � ������������ �����������",
                        ),
           "coding_standarts.��������� ��������� ����" =>
                        array(
                        "basic.������",
                        "naming.���������� �� ������" => array("filenames.����� ������",
                                         "classes.������",
                                         "interfaces.����������",
                                         "functions.������� � ������",
                                         "variables.����������",
                                         "constants.���������",
                                         ),
                        "style.����� ��������� ����" => array("code_demarcation.���������� PHP-����",
                                         "strings.������",
                                         "keywords.�������� �����",
                                         "arrays.�������",
                                         "classes.������",
                                         "functions.������� � ������",
                                         "control_structures.����������� ���������",
                                         "comments.�����������",
                                         ),
                        ),
            "glossary.������� � �����������" => array("common.�����"
                                         ),
            );


function render($id) {
    $path = 'docs/' . $id . '.php';
    if(!file_exists($path)) {
        exit;
    }

    $note = '
<div class="note">
';
    $end = "\r\n</div>\r\n";

    $example = '
<div class="example">
';

    $content = file_get_contents($path);
    $content = preg_replace("/<!--\s*(.*?)?-?code\s*(\d+)\s*-->/ie", 'include_code("' . $id . '-$2", "$1");', $content);
    $content = preg_replace("/<<code\s*(.*?)>>(.*?)<<\/code>>/ise", "highlightInlineCode('$1', str_replace('\\\"', '\"', html_entity_decode('$2')));", $content);



    //$content = str_replace(array("<<code>>", "<</code>>"), array("<!-- code start here -->\n<div class=\"code\"><div class=\"code_border\">\n<code>\n", "\n</code>\n</div></div>\n<!-- code end here -->\n"), $content);
    $content = str_replace(array("<<pre>>", "<</pre>>"), array("<!-- code start here -->\n<div class=\"code\"><div class=\"code_border\">\n<pre>\n", "\n</pre>\n</div></div>\n<!-- code end here -->\n"), $content);

    $content = str_replace(array('<<note>>', '<</note>>'), array($note, $end), $content);
    $content = str_replace(array('<<example>>', '<</example>>'), array($example, $end), $content);

    // ��������� ������
    $content = str_replace(array('<<c1>>', '<</c1>>'), array('<strong class="red">', '</strong>'), $content);
    $content = str_replace(array('<<c2>>', '<</c2>>'), array('<strong class="blue">', '</strong>'), $content);
    $content = str_replace(array('<<c3>>', '<</c3>>'), array('<strong class="orange">', '</strong>'), $content);
    $content = str_replace(array('<<c4>>', '<</c4>>'), array('<strong class="green">', '</strong>'), $content);

    return $content;
}

function include_code($id, $type) {
    $path = 'codes/' . $id . '.php';
    $type = trim($type);
    if(!file_exists($path)) {
        echo "<font color=red>[code for '$id' doesn't exists]</font>";
        exit;
    }
    if (empty($type)) {
       // return '<div class="code"><div class="code_border">' . highlight_file($path, 1) . '</div></div>';
    }
    include_once 'highlighter/geshi.php';
    if ($type == 'html') { $type = 'html4strict'; }
    $geshi = new GeSHi(file_get_contents($path), $type);
    return '<div class="code"><div class="code_border">' . $geshi->parse_code() . '</div></div>';
}


function highlightInlineCode($type, $code) {
    $type = trim($type);
    $code = trim($code);

    include_once 'highlighter/geshi.php';
    if ($type == 'html') { $type = 'html4strict'; }
    $geshi = new GeSHi($code, $type);
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


if (!isset($_REQUEST['cat'])) {
    require_once('header.inc.php');
    echo "<strong>����������</strong><br />\n<dl>\n";
    $i = 1;
    // ��� ���������
    foreach ($menu as $meta => $items) {
        $meta = explode('.', $meta, 2);
        $title = trim($meta[1]);
        $link = trim($meta[0]);

        echo '<dt><a href="' . $link . '.html#' . $link . '">' . $i . '. ' . $title . "</a></dt>\n";

        $n = 1;
        // ��� ������������
        echo '<dd><dl>';
        foreach ($items as $submeta => $subitem) {
            $num = $i . '.' . $n;
            if (is_array($subitem)) {

                $submeta = explode('.', $submeta, 2);
                $subtitle = trim($submeta[1]);
                $sublink = $link . '.' .trim($submeta[0]);

                $m = 1;
                echo '<dt><a href="' . $sublink . '.html#' . $sublink . '">' . $num . '. ' . $subtitle . "</a></dt>\n";
                echo '<dd><dl>';
                // ������� � �������������
                foreach ($subitem as $subsubmeta) {
                    $num = $i . '.' . $n . '.' . $m;

                    $subsubmeta = explode('.', $subsubmeta, 2);
                    $subsubtitle = trim($subsubmeta[1]);

                    $subsublink = $sublink . '.' .trim($subsubmeta[0]);

                    echo '<dt><a href="' . $sublink . '.html#' . $subsublink .'">' . $num . '. ';
                    echo $subsubtitle . "</a> " . checkFile($subsublink) . "</dt>\n";

                    $m++;
                }
                echo '</dl></dd>';

            } else {
                $subitem = explode('.', $subitem, 2);
                $subtitle = trim($subitem[1]);
                $sublink = $link . '.' .trim($subitem[0]);

                echo '<dt><a href="' . $sublink . '.html#' . $sublink .'">' . $num . '. ' . $subtitle . "</a>" . checkFile($sublink) . "</dt>\n";
            }
            $n++;

        }
        echo '</dl></dd>';

        $i++;
    }
    echo "</dl>\n";
} else {

    $cat = explode(".", $_REQUEST["cat"]);
    $paths = getPaths($menu);

    $tmp = $paths;

    // ������� �� �������� � �������������
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
        $title = $paths[$_REQUEST['cat']][2];
    } else {
        exit('������ ������� � ������������ ������ ���...');
    }
    require_once('header.inc.php');

    echo '<div class="navigation"><table width="99%" summary="Navigation">
    <tr>
     <td style="width: 20%; text-align: left;">';
    if($prev && $prev != $_REQUEST['cat']) {
        echo '<a href="' . $prev . '.html"><span style="font-size: 120%;">&larr;</span> �����</a>';
    } else {
        //echo '�����';
    }
    echo '</td>
       <td style="width: 60%; text-align: center;"><a href="' . $cat[0] . '.html">' . $paths[$cat[0]][1] . '. ' . $paths[$cat[0]][2] . '</a></td>
       <td style="width: 20%; text-align: right;">';

    if($path != $_REQUEST['cat']) {
        echo '<a href="' . $path . '.html">������ <span style="font-size: 120%;">&rarr;</span></a>';
    } else {
        //echo '������';
    }

    echo '
     </td>
    </tr>
    </table></div>';


    if (isset($cat[1])) {
        $category = $paths[$cat[0]][0];
        $tmp = $paths[$_REQUEST['cat']][0];

        echo '<p class="title"><a name="' . $_REQUEST['cat'] . '"></a>' . $paths[$_REQUEST['cat']][1] . ' ' . $paths[$_REQUEST['cat']][2] . '</p>';
        if (isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            $i = 1;
            echo "<dl>";
            foreach($menu[$category][$tmp] as $title => $value) {

                $meta = (is_array($value)) ? $title : $value;
                $meta = explode('.', $meta, 2);
                $title = trim($meta[1]);
                $name = $_REQUEST['cat'];
                $linkname = $_REQUEST['cat'] . '.' . trim($meta[0]);

                $num = $paths[$_REQUEST['cat']][1];

                echo '<dt><a href="' . $name . '.html#' . $linkname . '">' . $num . '.' . $i . ' ';
                echo $title . "</a></dt>\n";
                $i++;
            }
            echo "</dl>";
        }


        if(isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            foreach ($menu[$category][$tmp] as $key => $title) {

                $meta = explode('.', $title, 2);
                $title = trim($meta[1]);
                $link = trim($meta[0]);

                $id = $_REQUEST['cat'] . '.' . $link;
                $num = $paths[$_REQUEST['cat']][1] . '.' . ($key + 1);
                echo '<div class="subtitle"><a name="' . $id . '"></a>' . $num . ' ' . $title . '</div>';
                echo render($id);
            }
        } else {
            echo render($_REQUEST['cat']);
        }

    } else {
        $tmp = $paths[$cat[0]][0];

        $i = 1;
        echo "<dl>";
        foreach($menu[$tmp] as $title => $value) {
            $meta = (is_array($value)) ? $title : $value;
            $meta = explode('.', $meta, 2);
            $title = trim($meta[1]);
            $link = trim($meta[0]);


            $num = $paths[$cat[0]][1] . "." . $i;
            $link = $cat[0] . '.' . $link;

            echo '<dt><a href="' . $link . '.html#' . $link . '">' . $num . '. ';
            echo $title . "</a></dt>\n";
            $i++;
        }
        echo "</dl>";
    }



    echo '<div class="navigation_f"><table width="99%" summary="Navigation">
    <tr>
     <td style="width: 20%; text-align: left;" valign="top">';

    if($prev && $prev != $_REQUEST['cat']) {
        echo '<a href="' . $prev . '.html"><span style="font-size: 120%;">&larr;</span> �����</a>';
    } else {
        //echo '�����';
    }
    echo '</td>
       <td style="width: 60%; text-align: center;"><a href="' . $cat[0] . '.html">' . $paths[$cat[0]][1] . '. ' . $paths[$cat[0]][2] . '</a><br /><a href="index.html">������</a></td>
       <td style="width: 20%; text-align: right;" valign="top">';

    if($path != $_REQUEST['cat']) {
        echo '<a href="' . $path . '.html">������ <span style="font-size: 120%;">&rarr;</span></a>';
    } else {
        //echo '������';
    }

    echo '
     </td>
    </tr>
    </table></div>';

}
?>
</div>
</body>
</html>