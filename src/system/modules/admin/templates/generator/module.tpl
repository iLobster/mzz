{{*<?*}}{{chr(60)}}?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * {{$name}}Module
 *
 * @package modules
 * @subpackage {{$name}}
 * @version 0.0.1
 */
class {{$name}}Module extends simpleModule
{
    protected $classes = array();

	protected $roles = array();

	protected $version = '0.0.1';

	protected $icon = null;

	/**
     * Returns array of requirements or empty array if all ok
     *
     * @return array
     */
    public function checkRequirements()
    {
        return array();
    }
}
?>
