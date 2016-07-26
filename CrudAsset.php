<?php 

namespace shmilyzxt\kartikcrud;

use kartik\base\AssetBundle;

/**
 * 资源包
 * @author shmilyzxt <49783121@qq.com>
 * @since 1.0
 */
class CrudAsset extends AssetBundle
{
    public $sourcePath = '@shmilyzxt/kartikcrud/assets';

    public $css = [
        'ajaxcrud.css',
        'kv-grid-fix.css'
    ];
    
    public $js = [
        'ModalRemote.js',
        'ajaxcrud.js',
        'kv-grid-checkbox-fix.js',
        'kv-detail-view-fix.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kartik\grid\GridResizeColumnsAsset',
        'kartik\detail\DetailViewAsset',
        'kartik\grid\GridViewAsset',
        'kartik\dialog\DialogBootstrapAsset',
        'kartik\dialog\DialogAsset',
    ];
    
   public function init() {
       parent::init();
   }
}
