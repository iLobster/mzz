<?

class stubMapperSelectDataModify extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'simple';

    protected function selectDataModify()
    {
        $modifyFields = array();

        // @todo Сделать, чтобы указывать
        // $modifyFields['foo'] = new sqlFunction('REVERSE', '`foo`');

        $modifyFields['simple_foo'] = "REVERSE(`foo`)";
        return $modifyFields;
    }

    protected function insertDataModify(&$fields)
    {
        $fields['foo'] = new sqlFunction('REVERSE', $fields['foo']);

    }

    public function convertArgsToId($args)
    {
    }
}

?>