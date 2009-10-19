<?php
fileLoader::load('pager/pager');
class pagerPlugin extends observer
{
    protected $pager;

    public function __construct(pager $pager)
    {
        $this->pager = $pager;
        parent::__construct();
    }

    public function preSqlSelect(criteria $criteria)
    {
        $criteriaForCount = clone $criteria;
        $criteriaForCount->clearSelect()->select(new sqlFunction('count', new sqlOperator('DISTINCT', $this->mapper->table(false) . '.' . $this->mapper->pk())), 'cnt');
        $selectForCount = new simpleSelect($criteriaForCount);

        $this->pager->setCount($this->mapper->db()->getOne($selectForCount->toString()));

        $criteria->append($this->pager->getLimitQuery());

        $this->mapper->detach($this->getName());
    }

    public function getPager()
    {
        return $this->pager;
    }
}

?>