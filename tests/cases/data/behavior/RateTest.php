<?php
/**
 * li3_rate: a lithium php rating behavior
 *
 */

namespace li3_rate\tests\cases\data\behavior;


use lithium\data\Connections;
//use lithium\data\model\Query;
//use lithium\data\entity\Record;
use lithium\tests\mocks\data\model\MockDatabase;

use li3_rate\tests\mocks\data\model\MockDatabaseCoffee;

class RateTest extends \lithium\test\Unit {

	protected $_configs = array();

	public function setUp() {
		$this->db = new MockDatabase();
		$this->_configs = Connections::config();

		Connections::reset();
		Connections::config(array('mock-database-connection' => array(
			'object' => &$this->db,
			'adapter' => 'MockDatabase'
		)));
	}

	public function tearDown() {
		Connections::reset();
		Connections::config($this->_configs);
	}

	// public function testHasRates(){
	// 	$model = MockDatabaseCoffee::create(['id' => 12, 'rate' => 5]);//,array("exists" => true)
	// 	$data = $model->data();
	// 	var_dump($data);

	// 	$this->assertTrue(isset($data['rate']));
	// 	//$this->assertTrue(isset($data['votes']));
	// }

	public function testUpdated() {
		$model = MockDatabaseCoffee::create(array('id'=>13));
		$model->save();
		$data = $model->data();
		sleep(1);
		$this->assertEqual(0, $data['votes']);
		$this->assertEqual(0, $data['rate']);

		$model->save(['rate' => 1]);
		sleep(1);
		$data = $model->data();
		$this->assertEqual(1, $data['votes']);
		$this->assertEqual(1, $data['rate']);

		$model->save(['rate' => 2]);
		sleep(1);
		$data = $model->data();
		$this->assertEqual(2, $data['votes']);
		$this->assertEqual(1.5, $data['rate']);
		

		$model->save(['rate' => 3]);
		sleep(1);
		$data = $model->data();
		$this->assertEqual(3, $data['votes']);
		$this->assertEqual(2.25, $data['rate']);
		
	}
}

?>