<?php
/**
 * @var yii\web\View                               $this
 * @var \backend\widgets\mixedGallery\MixedGallery $widget
 *
 */

?>
<div class="row js_imageAddingWrapper">
	<div class="col-sm-12">
		<br>
		<p>Вставьте в поле ниже ссылку на видео с Youtube. Она может быть <b>любого*</b> формата</p>
	</div>
	<div class="col-sm-3 center-align">
		<span class="btn btn-default js_addImage" data-add-to="top">Добавить в начало</span>
	</div>
	<div class="col-sm-6 center-align">
		<input type="text" class="form-control js_addingLinkInput">
	</div>
	<div class="col-sm-3 center-align">
		<span class="btn btn-default js_addImage" data-add-to="bottom">Добавить в конец</span>
	</div>
	<div class="col-sm-12">
		<br>
		<div class="text-muted small">
			<p><b>*</b> поддерживаются следующие варианты ссылок:</p>
			<ul>
				<li>https://www.youtube.com/embed/xxxxxxxxxx</li>
				<li>https://www.youtube.com/watch<..............>v=xxxxxxxxxx</li>
				<li>https://youtu.be/xxxxxxxxxx</li>
			</ul>
		</div>
	</div>
</div>