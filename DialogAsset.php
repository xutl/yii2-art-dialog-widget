<?php
/**
 * Leaps Framework [ WE CAN DO IT JUST THINK IT ]
 *
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2015 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace xutl\dialog;

use yii\web\AssetBundle;

/**
 * Class DialogAsset
 * @package XuTongle\Dialog
 */
class DialogAsset extends AssetBundle
{

    public $sourcePath = '@bower/art-dialog';

    public $css = [
        'css/ui-dialog.css'
    ];

    public $js = [
        'dist/dialog-plus-min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
