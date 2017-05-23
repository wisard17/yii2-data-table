<?php
/**
 *
 */

namespace yii\datatable;

use yii\web\AssetBundle;

/**
 * Asset bundle for the DataTable files.
 *
 * @author Wisard Kalengkongan <wisard.kalengkongan@gmail.com>
 *
 */
class DataTableAsset extends AssetBundle
{
    public $sourcePath = '@vendor/datatables/datatables/media';
    public $css = [
        'css/dataTables.bootstrap.min.css',
    ];
    public $js = [
        'js/jquery.dataTables.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
