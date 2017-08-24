<?php

/**
 *
 * taginput
 *
 * @author CORNER CMS <dev@corner-cms.com>
 * @link http://www.corner-cms.com/
 */

namespace panix\ext\taginput;

use yii\web\AssetBundle;

class TinyMceLangAsset extends AssetBundle {

    public $sourcePath = '@vendor/panix/wgt-taginput/assets';
    
    public $css = ['css/jquery.tag-editor.css'];
    
    public $js = [
        YII_ENV_DEV ? 'js/jquery.tag-editor.js' : 'js/jquery.tag-editor.min.js',
    ];
    public $depends = [
        'panix\ext\taginput\Asset'
    ];

}
