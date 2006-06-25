<?php

class acl
{
    private $db;
    private $module;
    private $section;
    private $type;
    private $obj_id;
    private $uid;
    private $groups = array();
    private $result;

    public function __construct($module, $section, $type, $user, $object_id = 0)
    {
        $this->module = $module;
        $this->section = $section;
        $this->type = $type;
        $this->obj_id = $object_id;
        $this->uid = $user->getId();
        $this->groups = $user->getGroupsId();
    }

    public function get($param = null)
    {
        if (empty($this->result[$this->obj_id])) {
            if (empty($this->db)) {
                $this->db = db::factory();
            }

            $grp = "'', ";
            foreach ($this->groups as $val) {
                $grp .= $this->db->quote($val) . ', ';
            }
            $grp = substr($grp, 0, -2);

            $qry = "SELECT IF(MAX(`a`.`deny`), 0, MAX(`a`.`allow`)) AS `access`, `p`.`name` FROM `sys_access_modules` `m`
            INNER JOIN `sys_access_modules_list` `ml` ON `ml`.`id` = `m`.`module_id` AND `ml`.`name` = :module
            INNER JOIN `sys_access_modules_properties` `mp` ON `m`.`id` = `mp`.`module_id` AND `m`.`section` = :section
            INNER JOIN `sys_access_properties` `p` ON `mp`.`property_id` = `p`.`id`
            INNER JOIN `sys_access` `a` ON `a`.`module_property` = `mp`.`id`  AND `a`.`obj_id` = :obj_id AND `a`.`type` = :type
            WHERE `a`.`uid` = :uid OR `a`.`gid` IN (" . $grp . ")
            GROUP BY `a`.`module_property`";

            $stmt = $this->db->prepare($qry);

            $stmt->bindParam(':section', $this->section);
            $stmt->bindParam(':module', $this->module);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':obj_id', $this->obj_id);
            $stmt->bindParam(':uid', $this->uid);
            $stmt->bindParam(':param', $param);
            $stmt->execute();

            $this->result[$this->obj_id] = array();

            while ($row = $stmt->fetch()) {
                $this->result[$this->obj_id][$row['name']] = $row['access'];
            }
        }

        if (empty($param)) {
            return $this->result[$this->obj_id];
        } else {
            return isset($this->result[$this->obj_id][$param]) ? $this->result[$this->obj_id][$param] : 0;
        }
    }
}

?>