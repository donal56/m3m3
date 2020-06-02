<?php
    namespace app\assets;

    use yii\web\AssetBundle;
    
    class AppAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $css = [
            'css/semantic.min.css',
            'css/global.css',
            'css/standarize-bs.css',
        ];

        public $js = [
            'js/semantic.min.js',
            'js/base.js',
        ];

        public $depends = [
            'yii\web\JqueryAsset',
        ];

        public $jsOptions = [];
    }
?>
