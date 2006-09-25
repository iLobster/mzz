<?php
        $compositeResolver = new compositeResolver();
        $resolver1 = new firstResolver();
        $resolver2 = new secondResolver();

        $compositeResolver->addResolver($resolver1);
        $compositeResolver->addResolver($resolver2
        
        $compositeResolver->resolve('file.php');
?>