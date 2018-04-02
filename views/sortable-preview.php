<?php
/**
 * @var yii\web\View $this
 * @var Mixed        $widget
 *
 */


use yii\jui\Sortable;
use yii\web\JsExpression;
?>
<div class="imageListActionsPanel">
	<div class="js_imageListActionsPanel" style="display: none;">
		<span class="myBtn js_deleteFromList">удалить [x]</span>
	</div>
</div>
<?= Sortable::widget([
	'id' => 'sortable_' . $widget->options['id'],
	'items'         => [],
	'options'       => [
		'tag' => 'ul',
		'class' => 'sortableWrapper js_sortableWrapper'
	],
	'itemOptions'   => [
		'tag' => 'li',
		//'class' => 'sortableItem js_sortableItem'
	],
	'clientOptions' => [
		'cursor' => 'move',
		'update' => new JsExpression('function( event, ui ) {updateInputFromSortableList(getParentGalleryBlock($(ui.item)))}'),
	],
]);
?>