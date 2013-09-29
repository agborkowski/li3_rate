<?php
/**
 * li3_rate: a lithium php behavior
 *
 * @copyright     Copyright 2011, weluse GmbH (http://weluse.de)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_rate\tests\mocks\data\model;
use li3_behaviors\data\model\Behaviors;
use lithium\tests\mocks\data\model\MockDatabase;

class MockDatabaseCoffee extends \lithium\data\Model {
	use Behaviors;

	protected $_actsAs = [
		'Rate' => [
			'rate' => 'rate',
			'votes' => 'votes',
			'scale' => 10
		]
	];

	protected $_meta = array(
		'connection' => 'mock-database-connection'
	);

	protected $_schema = array(
		'id' => array('type' => 'integer'),
		'author_id' => array('type' => 'integer'),
		'title' => array('type' => 'string'),
		'rate' => array('type' => 'float'),
		'votes' => array('type' => 'integer'),
	);

	public function getBehaviors(){
		return $this->_actsAs;
	}

	public static function getFilters(){
		return static::$_methodFilters;
	}

	//copied methods
	public static $connection = null;

	public static function resetSchema() {
		static::_object()->_schema = array();
	}

	public static function overrideSchema(array $schema = array()) {
		static::_object()->_schema = $schema;
	}

	public static function instances() {
		return array_keys(static::$_instances);
	}

		public static function &connection() {
		if (!static::$connection) {
			$connection = new MockDatabase();
			return $connection;
		}
		return static::$connection;
	}
}

?>