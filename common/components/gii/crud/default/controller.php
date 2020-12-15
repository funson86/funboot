<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
use common\models\ModelSearch;
use <?= ltrim($generator->baseControllerClass, '\\') ?>;

/**
 * <?= $modelClass . "\n" ?>
 *
 * Class <?= $controllerClass . "\n" ?>
 * @package <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) . "\n" ?>
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
      * @var <?= $modelClass . "\n" ?>
      */
    public $modelClass = <?= $modelClass ?>::class;

    /**
      * 模糊查询字段
      * @var string[]
      */
    public $likeAttributes = ['name'];

   /**
    * 可编辑字段
    *
    * @var int
    */
   protected $editAjaxFields = ['name', 'sort'];

   /**
    * 导入导出字段
    *
    * @var int
    */
   protected $exportFields = [
       'id' => 'text',
       'name' => 'text',
       'type' => 'select',
   ];

}
