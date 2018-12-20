<?php
namespace backend\controllers;

use Yii;
use backend\components\BaseController;

/**
 * Class SiteController
 * @package backend\controllers
 * User: iBaiYang
 */
class SiteController extends BaseController
{
    public function actionIndex()
    {
        echo Yii::$app->request->getPathInfo();
        echo "</br>";
        echo "ddd";die;
    }

}