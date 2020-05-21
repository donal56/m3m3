<?php
    namespace app\assets;

    use yii\web\AssetBundle;

    class SidebarAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $css = [
            'css/sidebar.css',
        ];

        public $js = [
            'js/sidebar.js',
        ];

        public $depends = [
            'app\assets\AppAsset',
        ];

        public $jsOptions = ['defer' => 'defer'];
    }
?>
