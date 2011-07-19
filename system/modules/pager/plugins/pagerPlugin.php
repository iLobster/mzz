<?php

fileLoader::load('pager/pager');

class pagerPlugin extends observer
{
    CONST STRATEGY_COUNT = 0;
    CONST STRATEGY_SQL_CALC_FOUND_ROWS = 1;

    protected $pager;
    protected $pager_strategy;

    public function __construct(pager $pager, $pager_strategy = self::STRATEGY_COUNT)
    {
        $this->pager = $pager;
        $this->pager_strategy = $pager_strategy;
        parent::__construct();
    }

    public function preSqlSelect(criteria $criteria)
    {
        switch ($this->pager_strategy) {
            case self::STRATEGY_SQL_CALC_FOUND_ROWS:
                $criteria->selectOption('SQL_CALC_FOUND_ROWS');
                $criteria->append($this->pager->getLimitQuery());
                break;

            default:
                $criteriaForCount = clone $criteria;
                $criteriaForCount->clearSelect()->clearOrder()->select(new sqlFunction('count', new sqlOperator('DISTINCT', $this->mapper->table(false) . '.' . $this->mapper->pk())), 'cnt');
                $selectForCount = new simpleSelect($criteriaForCount);

                $this->pager->setCount($this->mapper->db()->getOne($selectForCount->toString()));

                $criteria->append($this->pager->getLimitQuery());
                $this->mapper->detach($this->getName());
                break;
        }
    }

    public function postSqlSelect($stmt)
    {
        if ($this->pager_strategy === self::STRATEGY_SQL_CALC_FOUND_ROWS) {
            $this->pager->setCount($this->mapper->db()->getOne('SELECT FOUND_ROWS()'));
            $this->mapper->detach($this->getName());
        }
    }

    public function getPager()
    {
        return $this->pager;
    }
}

?>