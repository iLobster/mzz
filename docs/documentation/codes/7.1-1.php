<?php
    $criteria = new criteria('table');
    $select = new simpleSelect($criteria);
    $select->toString(); // ����� "SELECT * FROM `table`"
?>