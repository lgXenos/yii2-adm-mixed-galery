# yii2 Admin Mixed Gallery

## Установка / Install

`composer require lg-xenos/yii2-adm-mixed-galery`

**`backend/config/bootstrap.php`**
```php
Yii::$container->set('lgxenos\yii2\admMixedGallery\AdmMixedGallery', [
    'fileManagerPathTpl' => '/adm-scripts/responsivefilemanager/filemanager/dialog.php?type=1&field_id=%s&relative_url=0&callback=MixedGalleryCallBack'
]);
```

**`backend/view/test/test.php`**
```php
echo  $form->field($model, 'doc_gallery')
      ->widget(\lgxenos\yii2\admMixedGallery\AdmMixedGallery::className())->label(false)
```

![about](about.png)

