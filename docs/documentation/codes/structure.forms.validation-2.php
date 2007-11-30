<?php
    $validator->add('callback', 'email', 'Введён неправильный e-mail', array('is_valid_email')); 
    
    function is_valid_email($email)
    {
        return preg_match('/^[a-zA-Z0-9\._-]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/', $email));
    }
?>