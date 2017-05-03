<?php
namespace usesgraphcrt\checkPrint;

use yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if(!$app->has('checkPrint')) {
            $app->set('checkPrint', ['class' => 'usesgraphcrt\checkPrint\Print']);
        }

    }
}