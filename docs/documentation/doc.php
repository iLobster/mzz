<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>������������</title>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
        <link rel="stylesheet" type="text/css" href="basic.css" />
    </head>
<body>

<div id="content">

<div id="title">������������ mzz</div>
<div id="version">������ 0.1.0</div>


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
    $content = file_get_contents($path);
    $content = preg_replace("/<!--\s*code\s*(\d+)\s*-->/ie", 'include_code("' . $id . '-$1");', $content);
    return $content;
}

function include_code($id) {
    $path = 'codes/' . $id . '.php';
    if(!file_exists($path)) {
        echo "<font color=red>[code for '$id' doesn't exists]</font>";
        exit;
    }
    return '<div class="code">' . highlight_file($path, 1) . '</div><br />';
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

    echo '<div class="navigation"><table width="99%" summary="Navigation">
    <tr>
     <td width="20%" align="left">';
    if($prev != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $prev . '">�����</a>';
    } else {
        echo '�����';
    }
    echo ' | <a href="' . $_SELF . '">������</a></td>
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


        echo '<p class="title">' . $_REQUEST['cat'] . ' ' . $paths[$_REQUEST['cat']] . '</p>';
        if(isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            foreach ($menu[$category][$tmp] as $key => $title) {
                $id = $_REQUEST['cat'] . '.' . ($key + 1);
                echo '<p class="subtitle">' . $id . ' ' . $title . '</p>';
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
            echo '<dt><a href="' . $_SELF . '?cat=' . $num . '">' . $num . '. ';
            echo (is_array($value)) ? $title : $value;
            echo "</a></dt>\n";
            $i++;
        }
        echo "</dl>";
    }



    echo '<div class="navigation_f"><table width="99%" summary="Navigation">
    <tr>
     <td width="20%" align="left">';
    if($prev != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $prev . '">�����</a>';
    } else {
        echo '�����';
    }
    echo ' | <a href="' . $_SELF . '">������</a></td>
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

}
?>


</div>
</body>
</html>