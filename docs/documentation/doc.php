<?php
/**
 * ��������� ��� ����: <!-- ��� code ����� -->
 * ������� ��������� ����: html, apache, css, ini, javascript, mysql, smarty, sql, xml
 * ���� ��� �� ������, �� ������������ ����������� ������� highlight_file
 *
 */

$menu = array("intro.�����������" =>
                        array(
                        "about.��������",
                        ),
           "setup.��������� � ���������" =>
                        array(
                        "system_requirements.����������� ����������",
                        "linux.��������� �� linux",
                        "windows.��������� �� windows",
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
                        "classes.�������� (��� ���) ������ �� ./system"
                                => array("toolkit.������",
                                         "request.Request",
                                         "resolver.Resolver",
                                         "dataspace.Dataspace",
                                         "frontcontroller.Frontcontroller"
                                         ),
                        "run.������� ������� ����������",
                        "mvc.MVC",
                        "urls.��������� �����, ��� ����� ����� ������",
                        "orm.ORM",
                        "folders.��������� ��������� mzz",
                        "files.���������� ��������� ������ (����� �������-���� ���)",
                        "jip.JIP � AJAX",
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
                        "simple.�������� Simple (���� ��� �� � �������� �������� ��� �� ���� ��� ��������� �������������) + �������� ��������� ����� �������",
                        "news.�������� ������ News",
                        "page.�������� ������ Page",
                        "timer.�������� ������ Timer",
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
                        ),
           "acl.������������ � �����" =>
                        array(
                        "users.���������� ��������������",
                        "groups.���������� ��������",
                        "permissions.���������� �������",
                        ),
           "db.����������� ������ � ��" =>
                        array(
                        "queries.����������� ��������. ������������� criteria",
                        "tree.������ � ������������ �����������",
                        ),
           "coding_standarts.��������� ��������� ����" =>
                        array(
                        "files.������ PHP-������" => array("main.������",
                                         "indentation.�������",
                                         "line_termination.�������� �����",
                                         ),
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
            );


function render($id) {
    $path = 'docs/' . $id . '.php';
    if(!file_exists($path)) {
        exit;
    }

    $note = '
<div class="note">
<table border="0" summary="note">
<tr>
<td valign="top" width="30"><img alt="����������" src="note.png" width="27" height="33" /></td>
<td valign="top"><strong>����������</strong><br />';

    $note_end = '</td>
</tr>
</table>
</div>
';



    $content = file_get_contents($path);
    $content = preg_replace("/<!--\s*(.*?)?-?code\s*(\d+)\s*-->/ie", 'include_code("' . $id . '-$2", "$1");', $content);
    $content = str_replace(array("<<code>>", "<</code>>"), array("<!-- code start here -->\n<div class=\"code\">\n<code>\n", "\n</code>\n</div>\n<!-- code end here -->\n"), $content);
    $content = str_replace(array("<<pre>>", "<</pre>>"), array("<!-- code start here -->\n<div class=\"code\">\n<pre>\n", "\n</pre>\n</div>\n<!-- code end here -->\n"), $content);

    $content = str_replace(array('<<note>>', '<</note>>'), array($note, $note_end), $content);

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
        return '<div class="code">' . highlight_file($path, 1) . '</div>';
    }
    include_once 'highlighter/geshi.php';
    if ($type == 'html') { $type = 'html4strict'; }
    $geshi = new GeSHi(file_get_contents($path), $type);
    return '<div class="code">' . $geshi->parse_code() . '</div>';
}


function checkFile($num) {
    if(!file_exists('docs/' . $num . '.php') || filesize('docs/' . $num . '.php') < 6) {
        touch('docs/' . $num . '.php');
        return ' <font style="color: red;">[todo]</font>';
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
     <td width="20%" align="left">';
    if($prev && $prev != $_REQUEST['cat']) {
        echo '<a href="' . $prev . '.html">�����</a>';
    } else {
        echo '�����';
    }
    echo '</td>
       <td width="60%" align="center"><a href="' . $cat[0] . '.html">' . $paths[$cat[0]][1] . '. ' . $paths[$cat[0]][2] . '</a></td>
       <td width="20%" align="right">';

    if($path != $_REQUEST['cat']) {
        echo '<a href="' . $path . '.html">������</a>';
    } else {
        echo '������';
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
     <td width="20%" align="left" valign="top">';
    if($prev != $_REQUEST['cat']) {
        echo '<a href="' . $prev . '.html">�����</a>';
    } else {
        echo '�����';
    }
    echo '</td>
       <td width="60%" align="center"><a href="' . $cat[0] . '.html">' . $paths[$cat[0]][1] . '. ' . $paths[$cat[0]][2] . '</a><br /><a href="index.html">������</a></td>
       <td width="20%" align="right" valign="top">';

    if($path != $_REQUEST['cat']) {
        echo '<a href="' . $path . '.html">������</a>';
    } else {
        echo '������';
    }

    echo '
     </td>
    </tr>
    </table></div>';

}
?>
</div>
<br />
</body>
</html>