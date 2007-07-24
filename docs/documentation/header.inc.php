<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title><?php echo isset($title) ? $title : 'Документация'; ?> | MZZ.Framework</title>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
        <link rel="stylesheet" type="text/css" href="basic.css" />
        <link rel="shortcut icon" href="favicon.ico" />
        <script type="text/javascript">
        var timer = 0;

        function showSidebar()
        {
           clearTimeout(timer);
           if (document.getElementById('sidebar').style.display != 'block') {
               document.getElementById('sidebar').style.display = 'block';
           }
        }

        function hideSidebar()
        {
            timer = setTimeout(function () { document.getElementById('sidebar').style.display = 'none'; }, 2000)
        }
        </script>
    </head>
<body>


<div id="title">MZZ.Framework 0.1.x: Документация</div>
<div id="content">