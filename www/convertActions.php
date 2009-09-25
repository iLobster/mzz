<html>
    <head></head>
    <body>
        <form method="post">
            <input type="text" name="path" />
            <br />
            <input type="submit" value="shake it!" />
        </form>
        <?php
        if (isset($_POST['path']) && is_dir($_POST['path'])) {
            echo '<hr /><pre>';
            
            $path = realpath($_POST['path']);
            foreach (glob($path . DIRECTORY_SEPARATOR . '*.ini') as $file) {
                $baseNameWithoutExt = basename($file, '.ini');
                
                $newFilePath = dirname($file) . DIRECTORY_SEPARATOR . $baseNameWithoutExt . '.php';
                if (!is_file($newFilePath)) {
                    $ini = parse_ini_file($file, true);
                
                    $phpactionFile = "<?php\r\n";
                    $phpactionFile .= "//" . $baseNameWithoutExt . " actions config" . "\r\n\r\n";
                    
                    $phpactionFile .= "return array(\r\n";
                    foreach ($ini as $sect => $data) {
                        $phpactionFile .= "    '$sect' => array(\r\n";
                        foreach($data as $key => $value) {
                            $phpactionFile .= "        '$key' => '$value',\r\n";
                        }
                        $phpactionFile .= "    ),\r\n";
                    }
                    $phpactionFile .= ");\r\n?>";
                    file_put_contents($newFilePath, $phpactionFile);
                    echo $newFilePath . ' ok' . "\n";
                } else {
                    echo $newFilePath . ' skip' . "\n";
                }
            }
        }
        ?>
    </body>
</html>