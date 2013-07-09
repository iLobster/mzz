{{*<?*}}{{chr(60)}}?php
fileLoader::load('{{$module->getName()}}/models/{{$name}}');

/**
 * {{$name}}Mapper
 *
 * @package modules
 * @subpackage {{$module->getName()}}
 * @version 0.0.1
 */
class {{$name}}Mapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = '{{$name}}';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = '{{$table}}';

    /**
     * Map
     *
     * @var array
     */
    protected $map = {{$map}};
}

?>