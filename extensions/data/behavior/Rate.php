<?php
/**
 * li3_dateable: a lithium php behavior
 *
 * @copyright    Copyright 2013, AgBorkowski http://blog.aeonmedia.eu
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_rate\extensions\data\behavior;

class Rate extends \li3_behaviors\data\model\Behavior {

   	/**
	 * Default field names to slug
	 *
	 * @var array
	 */
	protected $_defaults = [
		'rate' => 'rate',
		'votes' => 'votes'
	];
   

   	protected function _init() {
		parent::_init();
		if (!$model = $this->_model) {
			throw new  ConfigException("`'model'` option needs to be defined.");
		}
		
		$behavior = $this;
		$model::applyFilter('save', function($self, $params, $chain) use ($behavior, $model) {
			//b4 save
			$params = $behavior->invokeMethod('_rate', [$model, $params]);
			$save =  $chain->next($self, $params, $chain);
			//after save
			return $save;
		});
	}

	protected function _rate($model, $params) {
		extract($this->_config);
		$entity = $params['entity'];
		if ($entity->exists()) {
			if (isset($params['data'][$rate])) {
				$params['data'][$votes] = $entity->{$votes} + 1;
				if ($entity->{$votes} > 0) {
					$params['data'][$rate] =   ($entity->{$rate} + $params['data'][$rate]) / 2; 					
				} else {
					$params['data'][$rate] = $params['data'][$rate]; 
				}
			}
		} else {
			$params['data'][$votes] = 0;
			$params['data'][$rate] = 0;
		}
		return $params;
	}
}