<?php
namespace shmilyzxt\kartikcrud;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * grid的全选widget
 * @author shmilyzxt <49783121@qq.com>
 * @since 1.0
 */
class BulkButtonWidget extends Widget{

	public $buttons;
	
	public function init(){
		parent::init();
		
	}
	
	public function run(){
		$content = '<div class="pull-left">'.
					'<input type="checkbox">'.
                   '<span class="glyphicon glyphicon-arrow-right"></span>全选'.
                   $this->buttons.
                   '</div>';
		return $content;
	}
}
?>
