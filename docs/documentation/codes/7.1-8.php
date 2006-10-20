<?php
    $criterion = new criterion('field', array('value1', 'value2'), criteria::IN);
    $criterion->generate(); // "`field` IN ('value1', 'value2')"
    
    $criterion = new criterion('field', 'value', criteria::NOT_EQUAL);
    $criterion->generate(); // "`field` <> 'value'"

    $criterion = new criterion('field', '%q_', criteria::LIKE);
    $criterion->generate(); // "`field` LIKE '%q_'"

    $criterion = new criterion('field', '', criteria::IS_NULL );
    $criterion->generate(); // "`field` IS NULL"

    $criterion = new criterion('field', array(1, 10), criteria::BETWEEN);
    $criterion->generate(); // "`field` BETWEEN '1' AND '10'"

    $criterion = new criterion('field', 'field2', criteria::EQUAL, true);
    $criterion->generate(); // "`field` = `field2`"
?>