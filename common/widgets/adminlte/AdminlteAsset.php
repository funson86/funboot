<?php

namespace common\widgets\adminlte;

use yii\web\AssetBundle;

/**
 * Class AdminlteAsset
 * @package common\widgets\adminlte
 * @author funson86 <funson86@gmail.com>
 */
class AdminlteAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/adminlte/resources/';

    public $css = [
        'plugins/fontawesome-free/css/all.min.css',
        'plugins/funboot/funboot.css',
        'plugins/ionicons/ionicons.min.css',
        'plugins/flag-icon-css/css/flag-icon.min.css',
        'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        'plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
        'plugins/sweetalert2/sweetalert2.min.css',
        'plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
        'plugins/toastr/toastr.min.css',
        'dist/css/adminlte.min.css',
    ];

    public $js = [
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
        'plugins/datatables/jquery.dataTables.min.js',
        'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
        'plugins/datatables-responsive/js/dataTables.responsive.min.js',
        'plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
        'plugins/sweetalert2/sweetalert2.all.min.js',
        'plugins/toastr/toastr.min.js',
        'dist/js/adminlte.min.js',
        'dist/js/demo.js',
    ];

    public $depends = [
        'common\widgets\adminlte\HeadJsAsset',
    ];
}
