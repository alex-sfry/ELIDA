<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * This asset bundle provides the base JavaScript files for the Yii Framework.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class YiiAssetMin extends AssetBundle
{
    public $sourcePath = '@yii/assets';
    // public $sourcePath = '@app/assetsMin';
    public $js = [
        'yii.js',
        // 'yii2.js',
    ];
    public $jsOptions = [
//        'defer' => '',
        'position' => View::POS_END
    ];
    public $depends = [
        'app\assets\JqueryAssetMin',
    ];
}
