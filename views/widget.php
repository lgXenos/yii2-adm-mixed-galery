<?php
/**
 * @var yii\web\View                               $this
 * @var \backend\widgets\mixedGallery\MixedGallery $widget
 *
 *        JS-классы описаны в \backend\widgets\mixedGallery\MixedGallery
 *
 */
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\jui\Resizable;
use yii\web\View;

$tabsConfig = [
	'items' => [
		[
			'active'  => true,
			'label'   => '>',
			'content' => '<br>
							<p>Сверху отображены загруженные для врача фото-видео</p>
							<p>Если навести на фотографию - будет видна ее ссылка.</p>
							<p>Для изменения позиции в списке - просто перетащите ее мышкой</p>
							<p>Для добавления нового элемента - используйте кнопки различных способов выше</p>
							<p>После клика - появится дополнительное меню. Для множественного выделения - удерживайте нажатым <mark> Ctrl </mark></p>
			',
		],
		[
			'label'   => '[ добавить файл из /upload/ ]',
			'content' => $this->render('add-from-upload', ['widget' => $widget])
		],
		[
			'label'   => '[ добавить Youtube-видео ]',
			'content' => $this->render('add-from-youtube', ['widget' => $widget])
		],
//		[
//			'label'   => '[ добавить папку из /upload/ ]',
//			'content' => 'Данное решение в разработке',
//		],
	]
];

// http://jquery.page2page.ru/index.php5/Растягиваемые_элементы
$resizableConfig = [
	'id'            => 'resizable_' . $widget->options['id'],
	'options'       => [
		'class' => 'resizableWraper',
	],
	'clientOptions' => [
		'grid'      => [20, 2],
		'handles'   => 's',
		'minHeight' => 160
	]
];

//iout(\common\models\DepartamentsModel::getDropdownArray());
//iout($widget->model->{$widget->attribute}); exit;

/*
https://www.youtube.com/watch?v=aBzhechPjSM
https://www.youtube.com/watch?v=Rdbi0HokcK0
/upload/specialists/gordeeva1_200x200_726.jpg
https://www.youtube.com/watch?v=-HA0nHDuq6Q
*/

$items = is_array($widget->model->{$widget->attribute}) ? array_flip($widget->model->{$widget->attribute}) : [];
$input = Html::activeDropDownList($widget->model, $widget->attribute, $items, [
	'multiple' => 1,
	'style'    => [
		'display' => 'none'
	]
]);

// $input = Html::activeTextarea($widget->model, $widget->attribute, ['hidden' => 'hidden']);

?>
<div class="row text-center">
	<span class="btn btn-default" data-toggle="collapse" data-target="#rolldown_<?= $widget->options['id'] ?>">Показать галерею врача</span>
</div>
<div class="row collapse js_mixedGalleryBlock" data-input-id="<?= $widget->options['id'] ?>" id="rolldown_<?= $widget->options['id'] ?>">
	<div class="col-sm-12">
		<?php
		// Resizable::begin($resizableConfig);
		echo $this->render('sortable-preview', ['widget' => $widget]);
		// Resizable::end();
		?>
	</div>
	<div class="col-sm-12">
		<?= Tabs::widget($tabsConfig) ?>
	</div>
	<?= $input ?>
</div>
