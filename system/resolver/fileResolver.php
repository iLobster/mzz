<?php
// �������� ������

class fileResolver
{
    public static function resolve( $application, $file = false, $ext = false )
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
        if (is_file(SYSTEM_DIR . '/modules/' . $postname)) {
            return SYSTEM_DIR . '/modules/' . $postname;
        } elseif ( is_file( SYSTEM_DIR . $postname ) ) {
            return SYSTEM_DIR . $postname;
        } elseif ( is_file( APPLICATION_DIR . $postname ) ) {
            return APPLICATION_DIR . $postname;
        } else {
            die('���� �� ������: ' . $postname);
        }
    }
    public static function includer( $application, $file = false )
    {
        // ��� ������� self �� 5
        $file = fileResolver::resolve( $application, $file );
        require_once $file;
    }
}

?>