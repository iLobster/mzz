<?php

class adminGeneratorMapper extends mapper
{
    protected $table = 'admin';
    protected $module = 'admin';

    public function createModule($name, $title, $icon, $order)
    {
        $this->db()->query('INSERT INTO `' . $this->db()->getTablePrefix() . 'sys_modules` (`name`, `title`, `icon`, `order`) VALUES
                                (' . $this->db()->quote($name) . ', ' . $this->db()->quote($title) . ', ' . $this->db()->quote($icon) . ', ' . (int)$order . ')');
        return $this->db()->lastInsertId();
    }

    public function renameModule($id, $name)
    {
        $stmt = $this->db()->prepare('UPDATE `' . $this->db()->getTablePrefix() . 'sys_modules` SET `name` = :name WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function updateModule($id, $data)
    {
        $stmt = $this->db()->prepare('UPDATE `' . $this->db()->getTablePrefix() . 'sys_modules` SET `icon` = :icon, `title` = :title, `order` = :order WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':icon', $data['icon'], PDO::PARAM_STR);
        $stmt->bindValue(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindValue(':order', $data['order'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteModule($id)
    {
        $this->db()->query('DELETE FROM `' . $this->db()->getTablePrefix() . 'sys_modules` WHERE `id` = ' . (int)$id);
    }

    public function createClass($name, $module_id)
    {
        $stmt = $this->db()->prepare('INSERT INTO `' . $this->db()->getTablePrefix() . 'sys_classes` (`name`, `module_id`) VALUES (:name, :module_id)');
        $stmt->bindValue(':module_id', $module_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $this->db()->lastInsertId();
    }

    public function renameClass($id, $name)
    {
        $stmt = $this->db()->prepare('UPDATE `' . $this->db()->getTablePrefix() . 'sys_classes` SET `name` = :name WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteClass($id)
    {
        $this->db()->query('DELETE FROM `' . $this->db()->getTablePrefix() . 'sys_classes` WHERE `id` = ' . (int)$id);
    }

    public function createAction($name, $class_id)
    {
        $action_id = $this->db()->getOne('SELECT `id` FROM `' . $this->db()->getTablePrefix() . 'sys_actions` WHERE `name` = ' . $this->db()->quote($name));

        if (!$action_id) {
            $this->db()->query('INSERT INTO `' . $this->db()->getTablePrefix() . 'sys_actions` (`name`) VALUES (' . $this->db()->quote($name) . ')');
            $action_id = $this->db()->lastInsertId();
        }

        $this->db()->query('INSERT INTO `' . $this->db()->getTablePrefix() . 'sys_classes_actions` (`class_id`, `action_id`) VALUES (' . (int)$class_id . ', ' . (int)$action_id . ')');
    }

    public function renameAction($oldName, $name, $class_id)
    {
        $action_id = $this->db()->getOne('SELECT `id` FROM `' . $this->db()->getTablePrefix() . 'sys_actions` WHERE `name` = ' . $this->db()->quote($oldName));
        $new_action_id = $this->db()->getOne('SELECT `id` FROM `' . $this->db()->getTablePrefix() . 'sys_actions` WHERE `name` = ' . $this->db()->quote($name));

        if (!$new_action_id) {
            $this->db()->query('INSERT INTO `' . $this->db()->getTablePrefix() . 'sys_actions` (`name`) VALUES (' . $this->db()->quote($name) . ')');
            $new_action_id = $this->db()->lastInsertId();
        }

        $this->db()->query('UPDATE `' . $this->db()->getTablePrefix() . 'sys_classes_actions` SET `action_id` = ' . $new_action_id . ' WHERE `action_id` = ' . $action_id . ' AND `class_id` = ' . (int)$class_id);
        return $new_action_id;
    }

    public function deleteAction($name, $class_id)
    {
        $action_id = $this->db()->getOne('SELECT `id` FROM `' . $this->db()->getTablePrefix() . 'sys_actions` WHERE `name` = ' . $this->db()->quote($name));
        if ($action_id) {
            $this->db()->query('DELETE FROM `' . $this->db()->getTablePrefix() . 'sys_classes_actions` WHERE `class_id` = ' . (int)$class_id . ' AND `action_id` = ' . $action_id);
            return $action_id;
        }
    }

    public function getActions($class_id)
    {
        $qry = 'SELECT `a`.`name`, `a`.`id` FROM `' . $this->db()->getTablePrefix() . 'sys_classes_actions` `ca`
                   INNER JOIN `' . $this->db()->getTablePrefix() . 'sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `ca`.`class_id` = ' . (int)$class_id;
        $stmt = $this->db()->query($qry);

        $actions = array();
        while ($row = $stmt->fetch()) {
            $actions[] = $row['name'];
        }

        return $actions;
    }

    /**
     * Получение списка каталогов, используемых для генерации модулей
     *
     * @param boolean $onlyWritable показывать только те, для которых есть права на запись
     * @param string $subfolder подкаталог в каталоге modules, права на запись в который будет проверяться
     * @return array
     */
    public function getDests($onlyWritable = false, $subfolder = '')
    {
        if ($onlyWritable) {
            $dest = $this->getDests(false, $subfolder);

            foreach ($dest as $key => $val) {
                if (!is_writable($val)) {
                    unset($dest[$key]);
                }
            }

            return $dest;
        }

        return array(
        'sys' => systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $subfolder,
        'app' => systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $subfolder);
    }

    public function getTableSchema($table)
    {
        $table = substr($this->db()->quote($table), 1, -1);

        $result = array();
        foreach ($this->db()->getAll('SHOW COLUMNS FROM `' . $table . '`') as $field) {
            $key = $field['Field'];

            preg_match('/^([^(]+)(?:\((\d+)\)\s?(.*))?$/', $field['Type'], $matches);
            $result[$key] = array('type' => $matches[1]);
            if ($matches[1] == 'int') {
                $result[$key]['range'] = $matches[3] ? array(0, pow(2, 32)) : array(-pow(2, 31) + 1, pow(2, 31));
            } elseif ($matches[1] == 'char' || $matches[1] == 'varchar') {
                $result[$key]['maxlength'] = (int)$matches[2];
            }
        }

        $row = $this->db()->getRow('SHOW CREATE TABLE `' . $table . '`');
        preg_match('/primary key\s+\(`([^`]+)`/si', $row['Create Table'], $matches);

        if (isset($matches[1])) {
            $result[$matches[1]]['options'][] = 'pk';
        }

        return $result;
    }

    public function mapFieldsFormatter($map)
    {
        foreach ($map as $key => & $value) {
            $key = explode('_', $key);
            $key = array_map('ucfirst', $key);
            $key = implode('', $key);

            $value['accessor'] = 'get' . $key;
            $value['mutator'] = 'set' . $key;

            if (isset($value['options']) && in_array('pk', $value['options'])) {
                $value['options'][] = 'once';
            }
        }

        return $map;
    }

    public function generateMapString($map)
    {
        $map_str = var_export($map, true);

        $map_str = preg_replace('/^( +)/m', '$1$1', $map_str);
        $map_str = preg_replace('/^/m', str_repeat(' ', 4) . '\\1', $map_str);
        $map_str = trim($map_str);

        return $map_str;
    }
}

?>