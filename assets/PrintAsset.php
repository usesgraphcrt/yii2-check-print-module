<?php
namespace usesgraphcrt\checkprint\assets;

use yii\web\AssetBundle;
use yii\helpers\Url;

class PrintAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $js = [
        'js/event-handler.js',
    ];

    public function init()
    {
        $this->getView()->registerJs('usesgraphcrt.checkprint.urlToPrint = "'.Url::toRoute(['/checkprint/kkm/print']).'";');
        $this->getView()->registerJs('usesgraphcrt.checkprint.urlToOpenSession = "'.Url::toRoute(['/checkprint/kkm/open-session']).'";');
        $this->getView()->registerJs('usesgraphcrt.checkprint.urlToCloseSession = "'.Url::toRoute(['/checkprint/kkm/close-session']).'";');
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}