<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo isset($title) ? $title : 'Документация'; ?> | Framy</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="basic.css" />
        <link rel="stylesheet" type="text/css" href="filesTree.css" />
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

<div id="title"><a href="index.html">Framy 1.0</a></div>
<div id="content">