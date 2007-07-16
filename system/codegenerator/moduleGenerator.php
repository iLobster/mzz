<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * moduleGenerator: ����� ��� ��������� ������
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.2
 */

class moduleGenerator
{
    /**
     * ������ ��� �������� ���������
     *
     * @var array
     */
    private $log = array();

    /**
     * ���� �� ��������, � ������� ����� ������������� �����
     *
     * @var string
     */
    private $dest;

    /**
     * �����������
     *
     * @param string $dest
     */
    public function __construct($dest)
    {
        $this->dest = $dest;

        define('CODEGEN', systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'codegenerator');
        define('MZZ', systemConfig::$pathToApplication);
        define('CUR', $this->dest);
    }

    /**
     * �������� ������
     *
     * @param string $module
     */
    public function delete($module)
    {
        $this->safeUnlink(CUR . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module);
        $this->safeUnlink(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $module);
        $this->safeUnlink(CUR . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'templates');
    }

    /**
     * ����� ������������ �������� �������� � ������� � ������������� � ��
     *
     * @param string $path
     */
    private function safeUnlink($path)
    {
        $handle = opendir($path);

        while (false !== ($item = readdir($handle))) {
            if ($item != '.' && $item != '..') {
                $name = $path . DIRECTORY_SEPARATOR . $item;
                if (is_dir($name)) {
                    $this->safeUnlink($name);
                } else {
                    unlink($name);
                }
            }
        }
        closedir($handle);

        rmdir($path);
    }

    /**
     * �������������� ������
     *
     * @param string $oldName
     * @param string $newName
     */
    public function rename($oldName, $newName)
    {
        $current_dir = getcwd();
        chdir(CUR);
        rename($oldName, $newName);
        rename($newName . DIRECTORY_SEPARATOR . $oldName . 'Factory.php', $newName . DIRECTORY_SEPARATOR . $newName . 'Factory.php');
        rename(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $oldName, systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $newName);
        //rename(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $oldName, systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $newName);
        chdir($current_dir);
    }

    /**
     * ��������� ������
     *
     * @param string $module
     * @return array
     */
    public function generate($module)
    {
        $current_dir = getcwd();
        chdir(CUR);

        $smarty = new mzzSmarty();
        $smarty->template_dir = CODEGEN . DIRECTORY_SEPARATOR . 'templates';
        $smarty->force_compile = true;
        $smarty->compile_dir = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'templates_c';
        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        if (!is_writeable(CUR)) {
            throw new mzzRuntimeException('��� ������� �� ������ � ������� ' . CUR);
        }

        // ������� �������� ����� ������
        if (!is_dir(CUR . DIRECTORY_SEPARATOR . $module)) {
            mkdir($module, 0700);
            $this->log[] = "�������� ������� ������ ������ �������";
        }
        chdir($module);

        $factoryName = $module . 'Factory';
        $factoryFilename = $factoryName . '.php';

        if (is_file($factoryFilename)) {
            throw new Exception('Error: factory file already exists');
        }

        // ������� ����� actions
        if (!is_dir('actions')) {
            mkdir('actions');
            $this->log[] = "������� actions ������ �������";
        }

        // ������� ����� controllers
        if (!is_dir('controllers')) {
            mkdir('controllers');
            $this->log[] = "������� controllers ������ �������";
        }
        // ������� ����� mappers
        if (!is_dir('mappers')) {
            mkdir('mappers');
            $this->log[] = "������� mappers ������ �������";
        }
        // ������� ����� maps
        if (!is_dir('maps')) {
            mkdir('maps');
            $this->log[] = "������� maps ������ �������";
        }

        // ������ ����� � ��������� ���������
        if (!is_dir(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $module)) {
            mkdir(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'act' . DIRECTORY_SEPARATOR . $module);
            $this->log[] = "������� ��� �������� �������� ������";
        }

        // ������ ����� � ���������
        /*if (!is_dir(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $module)) {
            mkdir(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $module);
            $this->log[] = "������� ��� �������� ������";
        } */
        // ������� ����� controllers
        if (!is_dir('templates')) {
            mkdir('templates');
            $this->log[] = "������� templates ������ �������";
        }

        $factoryData = array(
        'factory_name' => $factoryName,
        'module' => $module,
        );

        // ���������� ������ � ���� �������
        $smarty->assign('factory_data', $factoryData);
        $factory = $smarty->fetch('factory.tpl');
        file_put_contents($factoryFilename, $factory);
        $this->log[] = '���� ' . $module . DIRECTORY_SEPARATOR . $factoryFilename . ' ������ �������';

        chdir($current_dir);

        return $this->log;
    }
}

?>