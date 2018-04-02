<?php

namespace lgxenos\yii2\admMixedGallery;

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\jui\Sortable;
use yii\widgets\InputWidget;

/**
 * Class MixedGallery
 * @package backend\widgets\mixedGallery
 *
 *      выводим админку галереи со смешаннам контентом
 *
 *          используемые JS-классы:
 *
 *          js_mixedGalleryBlock    - корневой элемент всей конструкции. его искать через parents()
 *
 *          js_sortableWrapper      - корневой элемент сортируемого списка. элемент UL.
 *                                  $( ".js_sortableWrapper" ).sortable( "refresh" );
 *                                  http://api.jqueryui.com/sortable/#method-refresh
 *
 *          js_youtubeWrapper       - блок добавления ссылки из ютуба. содержит js_addFromYouTube и js_youtubeLinkInput
 *
 *          js_uploadImageWrapper   - блок добавления 1й фотографии из папки аплоад
 *
 *
 */
class AdmMixedGallery extends InputWidget {
	public function run() {
		
		echo $this->render('widget', ['widget' => $this]);
		
		$this->registerClientScript();
	}
	
	private function registerClientScript() {
		
		$view = $this->getView();
		
		AdmMixedGalleryAsset::register($view);
		
		$js = <<<JS
			// после загрузки производим инициализацию всех инпутов галерей
			$('.js_mixedGalleryBlock').each(function (indx, galleryBlock) {
				galleryBlock = $(galleryBlock);
				updateSortableListFromInput(galleryBlock);
				selectAllOptionsInInputBlock(getActiveformInput(galleryBlock));
			});
			/*
			 на нужных ссылках инициализируем фанси-бокс
			 */
			$('.iframe-btn').fancybox({
				'width': 900,
				'height': 600,
				'type': 'iframe',
				'autoSize': false
			});
JS;
		$view->registerJs($js, \common\components\view\View::POS_READY);
		
	}
}
