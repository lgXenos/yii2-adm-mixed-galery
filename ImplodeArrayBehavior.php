<?php

namespace lgxenos\yii2\admMixedGallery;

use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\base\Behavior;

/**
 * Бихевиор, который работает с массивом в поле, которое изначально представлено строкой с разделителями
 *
 * Class ImplodeArrayBehavior
 * @package common\behaviors
 *
 */
class ImplodeArrayBehavior extends Behavior {

	/** @var  string чем склеиваем */
	public $glue = ';';

	/** @var  string поле, с которым идет работа */
	public $field;

	/**
	 * @return array
	 * @throws ErrorException
	 */
	public function events() {
		if (!$this->field) {
			throw new ErrorException('Не указано поле для обработки');
		}

		return [
			ActiveRecord::EVENT_BEFORE_INSERT => 'implodeField',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'implodeField',
			ActiveRecord::EVENT_AFTER_FIND    => 'explodeField',
		];
	}

	/**
	 * @param $event
	 */
	public function implodeField($event) {
		if(is_array($this->owner->{$this->field})) {
			$itemsRaw = $this->owner->{$this->field};
			$items = [];
			// перебираем все элементы, выкидываем лишние пустые
			foreach ($itemsRaw as $item){
				$item = trim($item);
				if($item != ''){
					$items[] = $item;
				}
			}
			$this->owner->{$this->field} = implode($this->glue, $items);
		}
	}

	/**
	 * @param $event
	 */
	public function explodeField($event) {
		if(trim($this->owner->{$this->field})==''){
			$this->owner->{$this->field} = [];
			return;
		}
		$this->owner->{$this->field} = explode($this->glue, $this->owner->{$this->field});
		if(!is_array($this->owner->{$this->field})){
			$this->owner->{$this->field} = [];
		}
	}

	/**
	 * @param        $field
	 * @param string $glue
	 *
	 * @return string
	 */
	public static function printFieldAsString($field, $glue = ','){
		if(is_array($field)){
			return implode($glue, $field);
		}

		return $field;
	}
}