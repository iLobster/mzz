<?php
        $item_one = "foo";
        $item_two = "bar";

        $dataspace->set('foo', $item_one);
        $dataspace->set('bar', $item_two);

        $dataspace->get('foo');
        $dataspace->get('bar');
?>