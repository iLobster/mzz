<?php
function getPaths($array, $path = '') {
    $values = array();

    $i = 1;

    foreach ($array as $key => $value) {
        $p = (empty($path)) ? $i : $path . '.' . $i;

        if(is_array($value)) {
            $values[$p] = $key;
            $values = $values + getPaths($value, $p);
        } else {
            $values[$p] = $value;
        }

        $i++;
    }

    return $values;
}

function render($id) {
    $path = 'docs/' . $id . '.php';
    if(!file_exists($path)) {
        exit;
    }

    $note = '
<div class="note">
<table border="0" summary="note">
<tr>
<td rowspan="2" width="50"><img alt="����������" src="note.png" width="40" height="49" /></td>
<td><strong>����������</strong></td>
</tr>
<tr>
<td valign="top">';


    $note_end = '</td>
</tr>
</table>
</div>
';



    $content = file_get_contents($path);
    $content = preg_replace("/<!--\s*code\s*(\d+)\s*-->/ie", 'include_code("' . $id . '-$1");', $content);
    $content = str_replace(array("<<code>>", "<</code>>"), array("<!-- code start here -->\n<div class=\"code\">\n<code>\n", "\n</code>\n</div>\n<!-- code end here -->\n"), $content);

    $content = str_replace(array('<<note>>', '<</note>>'), array($note, $note_end), $content);
    return $content;
}

function include_code($id) {
    $path = 'codes/' . $id . '.php';
    if(!file_exists($path)) {
        echo "<font color=red>[code for '$id' doesn't exists]</font>";
        exit;
    }
    return '<div class="code">' . highlight_file($path, 1) . '</div>';
}


function checkFile($num) {
    if(!file_exists('docs/' . $num . '.php') || filesize('docs/' . $num . '.php') < 6) {
        touch('docs/' . $num . '.php');
        return ' <font style="color: red;">[todo]</font>';
    } else {
        return '';
    }
}

$menu = array("�����������" =>
                        array(
                        "��������",
                        "������� ����������� (faq?)",
                        ),
           "��������� � ���������" =>
                        array(
                        "����������� ����������",
                        "��������� �� linux",
                        "��������� �� windows",
                        "������������"
                                => array("��������� ������������ (? ��������� config.php)",
                                         "��������� Rewrite ��� URL",
                                         "�������� map (?)"),
                        ),
           "��������� mzz" =>
                        array(
                        "�������"
                                => array("����� ��������",
                                         "������� {load}",
                                         "������� {add}",
                                         "������� {url}",
                                         ),
                        "�������� (��� ���) ������ �� ./system"
                                => array("������",
                                         "Request",
                                         "Resolver",
                                         "Dataspace",
                                         "Frontcontroller"
                                         ),
                        "������� ������� ����������",
                        "�������� � ������ ������ � �������",
                        "MVC",
                        "��������� �����, ��� ����� ����� ������",
                        "���",
                        "��������� ��������� mzz",
                        "���������� ��������� ������ (����� �������-���� ���)",
                        ),
           "������� �����" =>
                        array(
                        "��������� �������",
                        "�������� ������������ ��� �������",
                        "������������� ����������� �������",
                        "���������� ������ News ��� ����������� �������",
                        "������ �������� ������ ������ (?)",
                        ),
           "������ �������" =>
                        array(
                        "�������� ��������� ��������� ������ mzz"
                                => array("��������� ���������",
                                         "Actions",
                                         "Controllers",
                                         "Mappers",
                                         "Maps",
                                         ),
                        "�������� Simple (���� ��� �� � �������� �������� ��� �� ���� ��� ��������� �������������) + �������� ��������� ����� �������",
                        "�������� ������ News",
                        "�������� ������ Page",
                        "�������� ������ Timer",
                        ),
           "������������ � �����" =>
                        array(
                        "���������� ��������������",
                        "���������� ��������",
                        "���������� �������",
                        ),
            );

$_SELF = $_SERVER['PHP_SELF'];
if (!isset($_REQUEST['cat'])) {
    require_once('header.inc.php');
    echo "<strong>����������</strong><br />\n<dl>\n";
    $i = 1;
    // ��� ���������
    foreach ($menu as $title => $items) {
        echo '<dt><a href="' . $_SELF . '?cat=' . $i . '#' . $i . '">' . $i . '. ' . $title . "</a></dt>\n";

        $n = 1;
        // ��� ������������
        echo '<dd><dl>';
        foreach ($items as $subtitle => $subitem) {
            //
            $num = implode('.', array($i, $n));
            if (is_array($subitem)) {
                $m = 1;
                echo '<dt><a href="' . $_SELF . '?cat=' . $num . '#' . $num . '">' . $num . '. ' . $subtitle . "</a></dt>\n";
                echo '<dd><dl>';
                // ������� � �������������
                foreach ($subitem as $subsubitem) {
                    $num = implode('.', array($i, $n, $m));
                    echo '<dt><a href="' . $_SELF . '?cat=' . $i . '.' . $n . '#' . $num .'">' . $num . '. ';
                    echo $subsubitem . "</a> " . checkFile($num) . "</dt>\n";

                    $m++;
                }
                echo '</dl></dd>';

            } else {
                echo '<dt><a href="' . $_SELF . '?cat=' . $num . '#' . $num .'">' . $num . '. ' . $subitem . "</a>" . checkFile($num) . "</dt>\n";
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

    $prev = 1;

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
    
    $title = $paths[$_REQUEST['cat']];
    require_once('header.inc.php');

    echo '<div class="navigation"><table width="99%" summary="Navigation">
    <tr>
     <td width="20%" align="left">';
    if($prev != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $prev . '">�����</a>';
    } else {
        echo '�����';
    }
    echo '</td>
       <td width="60%" align="center"><a href="' . $_SELF . '?cat=' . $cat[0] . '">' . $cat[0] . '. ' . $paths[$cat[0]] . '</a></td>
       <td width="20%" align="right">';

    if($path != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $path . '">������</a>';
    } else {
        echo '������';
    }

    echo '
     </td>
    </tr>
    </table></div>';


    if (isset($cat[1])) {
        $category = $paths[$cat[0]];
        $tmp = $paths[$_REQUEST['cat']];


        echo '<p class="title"><a name="' . $_REQUEST['cat'] . '"></a>' . $_REQUEST['cat'] . ' ' . $paths[$_REQUEST['cat']] . '</p>';
        if (isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            $i = 1;
            echo "<dl>";
            foreach($menu[$category][$tmp] as $title => $value) {

                $num = $_REQUEST['cat'];
                echo '<dt><a href="' . $_SELF . '?cat=' . $num . '#' . $num . '.' . $i . '">' . $num . '. ';
                echo (is_array($value)) ? $title : $value;
                echo "</a></dt>\n";
                $i++;
            }
            echo "</dl>";
        }


        if(isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            foreach ($menu[$category][$tmp] as $key => $title) {
                $id = $_REQUEST['cat'] . '.' . ($key + 1);
                echo '<div class="subtitle"><a name="' . $id . '"></a>' . $id . ' ' . $title . '</div>';
                echo render($id);
            }
        } else {
            echo render($_REQUEST['cat']);
        }

    } else {
        $tmp = $paths[$cat[0]];
        $i = 1;
        echo "<dl>";
        foreach($menu[$tmp] as $title => $value) {

            $num = $cat[0] . "." . $i;
            echo '<dt><a href="' . $_SELF . '?cat=' . $num . '#' . $num . '">' . $num . '. ';
            echo (is_array($value)) ? $title : $value;
            echo "</a></dt>\n";
            $i++;
        }
        echo "</dl>";
    }



    echo '<div class="navigation_f"><table width="99%" summary="Navigation">
    <tr>
     <td width="20%" align="left" valign="top">';
    if($prev != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $prev . '">�����</a>';
    } else {
        echo '�����';
    }
    echo '</td>
       <td width="60%" align="center"><a href="' . $_SELF . '?cat=' . $cat[0] . '">' . $cat[0] . '. ' . $paths[$cat[0]] . '</a><br /><a href="' . $_SELF . '">������</a></td>
       <td width="20%" align="right" valign="top">';

    if($path != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $path . '">������</a>';
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