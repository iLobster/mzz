<?php

class i18nPlugin extends observer
{
    private $i18nFields = array();

    private $langId;

    private $forceLangId = false;

    protected $options = array(
        'postfix' => 'lang');

    protected function updateMap(& $map)
    {
        foreach ($map as $key => & $val) {
            if (isset($val['options']) && in_array('i18n', $val['options'])) {
                $val['options'][] = 'fake';
                $this->i18nFields[] = $key;
            }
        }

        $map['lang_id'] = array(
            'accessor' => 'getLangId',
            'options' => array(
                'fake',
                'ro'));
    }

    public function setMapper(mapper $mapper)
    {
        if (!isset($this->options['foreign_key'])) {
            $this->options['foreign_key'] = $mapper->pk();
        }

        $map = $mapper->map();
        $this->options['foreign_accessor'] = $map[$this->options['foreign_key']]['accessor'];

        return parent::setMapper($mapper);
    }

    private function getLangId()
    {
        if (empty($this->langId)) {
            $this->langId = systemToolkit::getInstance()->getLang();
        }

        return $this->langId;
    }

    public function resetLangId()
    {
        $this->langId = null;
    }

    public function setLangId($id)
    {
        $tmp = $this->langId;
        $this->langId = $id;
        $this->forceLangId = true;
        return $tmp;
    }

    public function preSqlSelect(criteria $criteria)
    {
        $criterion = new criterion('i18n.id', $this->mapper->table(false) . '.' . $this->options['foreign_key'], criteria::EQUAL, true);
        $criterion->addAnd(new criterion('i18n.lang_id', $this->getLangId()));
        $criteria->join($this->table(), $criterion, 'i18n', $this->forceLangId ? criteria::JOIN_LEFT : criteria::JOIN_INNER);
        $this->addSelectFields($criteria);
    }

    public function preSqlJoin(array & $data)
    {
        $criteria = $data[0];
        $alias = $data[1];

        $table_name = $alias . '_i18n';

        $criterion = new criterion($table_name . '.id', $alias . '.' . $this->options['foreign_key'], criteria::EQUAL, true);
        $criterion->addAnd(new criterion($table_name . '.lang_id', $this->getLangId()));
        $criteria->join($this->table(), $criterion, $table_name);
        $this->addSelectFields($criteria, $alias);
    }

    private function addSelectFields(criteria $criteria, $alias = null)
    {
        if (is_null($alias)) {
            $alias = $this->mapper->table(false);
            $self = 'i18n';
        } else {
            $self = $alias . '_i18n';
        }

        foreach (array_merge(array('lang_id'), $this->i18nFields) as $field) {
            $criteria->select($self . '.' . $field, $alias . mapper::TABLE_KEY_DELIMITER . $field);
        }
    }

    public function preUpdate(& $data)
    {
        if (is_array($data)) {
            $this->clearData($data);
            return;
        }

        $id = $data->{$this->options['foreign_accessor']}();
        $i18n_data = $data->exportChanged();
        $this->clearData($i18n_data, false);

        if (!empty($i18n_data)) {
            $criteria = new criteria($this->table());
            $criterion = new criterion('id', $id);
            $criterion->addAnd(new criterion('lang_id', $this->getLangId()));
            $criteria->where($criterion);

            $update = new simpleUpdate($criteria);

            if (!$this->mapper->db()->exec($update->toString($i18n_data))) {
                $i18n_data['lang_id'] = $this->getLangId();
                $i18n_data['id'] = $id;

                $insert = new simpleInsert($criteria);
                try {
                    $this->mapper->db()->query($insert->toString($i18n_data));
                } catch (PDOException $e) {
                }
            }
        }
    }

    public function preInsert(& $data)
    {
        if (is_array($data)) {
            $this->clearData($data);
        }
    }

    public function postSqlInsert(entity $object)
    {
        $i18n_data = $object->exportChanged();
        $this->clearData($i18n_data, false);
        $i18n_data['lang_id'] = $this->getLangId();
        $i18n_data['id'] = $this->mapper->db()->lastInsertId();

        $criteria = new criteria($this->table());
        $insert = new simpleInsert($criteria);

        $this->mapper->db()->query($insert->toString($i18n_data));
    }

    private function clearData(& $data, $notI18n = true)
    {
        foreach (array_keys($data) as $field) {
            if ($notI18n == in_array($field, $this->i18nFields)) {
                unset($data[$field]);
            }
        }
    }

    private function table()
    {
        return $this->mapper->table() . '_' . $this->options['postfix'];
    }
}

?>