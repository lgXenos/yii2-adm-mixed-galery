<?php

namespace lgxenos\yii2\admMixedGallery;

use yii\web\AssetBundle;

class MixedGalleryAsset extends AssetBundle {

    public $sourcePath = '@vendor/lg-xenos/yii2-adm-mixed-galery/assets';
	
	public $js = [
		'fancybox.min.js',
		'mixed-gall.js',
	];

	public $css = [
		'fancybox.css',
		'mixed-gall.css'
	];

	public $depends = [
		'yii\web\JqueryAsset',
		'yii\jui\JuiAsset',
	];

}
