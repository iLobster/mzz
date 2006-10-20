<?php
    $criterion = new criterion('field', 'value');
    $criterion->addAnd(new criterion('field2', 'value2'));
    $criterion->generate(); // "(`field` = 'value') AND (`field2` = 'value2')
    
    
    
    
    $criterion = new criterion();

    $cr1 = new criterion('field1', 'value1');
    $cr2 = new criterion('field2', 'value2');
    $cr3 = new criterion('field2', 'value3');
    $cr4 = new criterion('field4', 'value4', criteria::GREATER_EQUAL);
    $cr5 = new criterion('field5', 'value5', criteria::LESS_EQUAL);

    $cr2->addOr($cr3);
    $cr2->generate(); // "(`field2` = 'value2') OR (`field2` = 'value3')"

    $cr1->addAnd($cr2);
    $cr1->generate(); // "(`field1` = 'value1') AND ((`field2` = 'value2') OR (`field2` = 'value3'))"

    $cr4->addAnd($cr5);
    $cr4->generate(); // "(`field4` >= 'value4') AND (`field5` <= 'value5')"

    $criterion->add($cr1);
    $criterion->generate(); // "((`field1` = 'value1') AND ((`field2` = 'value2') OR (`field2` = 'value3')))"

    $criterion->addOr($cr4);
    $criterion->generate(); // "((`field1` = 'value1') AND ((`field2` = 'value2') OR (`field2` = 'value3'))) OR ((`field4` >= 'value4') AND (`field5` <= 'value5'))"
?>