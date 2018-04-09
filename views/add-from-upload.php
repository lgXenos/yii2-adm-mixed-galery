<?php
/**
 * @var yii\web\View                               		$this
 * @var \lgxenos\yii2\admMixedGallery\AdmMixedGallery 	$widget
 *
 */
use yii\helpers\Html;

$tmpFileInput = 'file_from_upload_' . $widget->options['id'];

$options = [
	'class'    => 'form-control',
	'readonly' => true,
	'id'       => $tmpFileInput
];
$url          = sprintf($widget->fileManagerPathTpl, $tmpFileInput); //"";



$input        = Html::textInput('upload__' . $widget->name, '', $options);
$selectImgBtn = Html::a('Выбрать другую картинку', $url, ['class' => 'btn iframe-btn btn-default', 'type' => 'button']);
$removeImgBtn = Html::tag('span', 'Удалить картинку', ['class' => 'btn btn-default js_RemoveImg', 'type' => 'button', 'data-img-id' => $options['id']]);
$imgPreview   = Html::tag('div', '&nbsp;', [
	'id'    => 'preview__' . $options['id'],
	'class' => 'imgSelectorPriview',
	// 'style' => 'background-image:url("' . $this->model->{$this->attribute} . '");'
]);

?>


<div class="row js_imageAddingWrapper">
	<div class="col-sm-12">
		<br>
		<p>Можно выбрать картинку из папок в /upload/</p>
	</div>
	<div class="col-sm-3 center-align">
		<span class="btn btn-default js_addImage" data-add-to="top">Добавить в начало</span>
	</div>
	<div class="col-sm-6 center-align">
		<a type="button" class="btn iframe-btn btn-default" href="<?=$url?>">Выбрать картинку</a>
		<input id="<?=$tmpFileInput?>" type="text" class="form-control js_addingLinkInput" readonly="readonly">
	</div>
	<div class="col-sm-3 center-align">
		<span class="btn btn-default js_addImage" data-add-to="bottom">Добавить в конец</span>
	</div>
</div>