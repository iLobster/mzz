<?php
// �������� ������

class fileResolver
{
    function resolve( $application, $file = false, $ext = false )
    {
        if ( $file === false ) {
            $file = $application;
        }
        if ( $ext === false ) {
            $ext = '.php';
        }
        // ��� ����� ������������� ����� �� ����������� �������
        $postname = '' . $application . '/' . $file . $ext;
        //echo $postname.'<br>';
        if (is_file(SYSTEM . '/modules/' . $postname)) {
            return SYSTEM . '/modules/' . $postname;
        } elseif ( is_file( SYSTEM . $postname ) ) {
            return SYSTEM . $postname;
        } elseif ( is_file( APPLICATION . $postname ) ) {
            return APPLICATION . $postname;
        } else {
            die('���� �� ������: ' . $postname);
        }
    }
    function includer( $application, $file = false )
    {
        // ��� ������� self �� 5
        $file = fileResolver::resolve( $application, $file );
        require_once $file;
    }
}

?>