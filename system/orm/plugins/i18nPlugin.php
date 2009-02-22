<?php

class i18nPlugin extends observer
{
    private $i18nFields = array();

    private $langId;

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

    public function preSqlSelect(criteria $criteria)
    {
        $criterion = new criterion('i18n.id', $this->mapper->table() . '.' . $this->options['foreign_key'], criteria::EQUAL, true);
        $criterion->addAnd(new criterion('i18n.lang_id', $this->getLangId()));
        $criteria->addJoin($this->table(), $criterion, 'i18n', criteria::JOIN_INNER);
        $this->addSelectFields($criteria);
    }

    private function addSelectFields(criteria $criteria, $alias = null)
    {
        if (is_null($alias)) {
            $alias = $this->mapper->table();
        }
        foreach (array_merge(array('lang_id'), $this->i18nFields) as $field) {
            $criteria->addSelectField('i18n.' . $field, $alias . mapper::TABLE_KEY_DELIMITER . $field);
        }
    }

    private function table()
    {
        return $this->mapper->table() . '_' . $this->options['postfix'];
    }
}

?>