<?php

function smarty_modifier_filesize($bytes)
{
        $bytes = max(0, (int) $bytes);
 
        $units = array('á', 'Êá', 'Ìá', 'Ãá', 'Òá', 'Ïá');
 
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
 
        return round($bytes / pow(1024, $power),2) . ' ' .$units[$power];
}

?>
