<?php

class session
{
    function start()
    {
        session_start();
    }
        
    function get($name)
    {
        return (isset($_SESSION[$name])) ? $_SESSION[$name] : null;
    }

    function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    function reset()
    {
    }

    function exists($name)
    {
    }

    function destroy($name)
    {
    }
}

?>