<?php

namespace usesgraphcrt\checkPrint;

use Yii;

class Module extends \yii\base\Module
{

    public $orderModel = 'pistol88\order\models\Order';
    public $orderElementModel = 'pistol88\order\models\Element';
    public $adminRoles = ['superadmin', 'administrator'];
    public $organizationInn = null;
    public $organizationAddress = null;
    public $examCheckSite = null;

    public function init()
    {
        parent::init();

    }
}
