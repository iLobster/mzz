<?php

class session
{

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