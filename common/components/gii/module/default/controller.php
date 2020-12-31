<?php
/**
 * This is the template for generating a controller class within a module.
 */

use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use <?= ltrim($generator->baseClass, '\\') ?>;

/**
 * Default controller for the `<?= $generator->moduleID ?>` module
 */
class DefaultController extends <?= StringHelper::basename($generator->baseClass) . "\n" ?>
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->goHome();
    }
}
