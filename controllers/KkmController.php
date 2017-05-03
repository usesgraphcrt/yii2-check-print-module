<?php

namespace usesgraphcrt\checkprint\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;


class KkmController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),

                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
        ];
    }

    public function actionOpenSession()
    {
        $this->enableCsrfValidation = false;

        $print = '
            ECR = new ActiveXObject("AddIn.FPrnM45");

            ECR.SlipDocCharLineLength = 32;
            ECR.SlipDocTopMargin = 0;
            ECR.SlipDocLeftMargin = 1;
            ECR.SlipDocOrientation = 0;

            ECR.DeviceEnabled = 1;

            if (ECR.GetStatus()){
                alert("Не получилось соединиться с ККМ!");
                ECR.DeviceEnabled = 0;
                window.close(); 
            } else {
                ECR.Password = 30;
                ECR.Mode = 1;
                ECR.SetMode();
                ECR.OpenSession();
				ECR.Beep();
				ECR.DeviceEnabled = 0;
				window.close(); 
                };';

        return '<script>'.$print.'</script>';

    }

    public function actionCloseSession()
    {
        $this->enableCsrfValidation = false;

        $print = '
                ECR = new ActiveXObject("AddIn.FPrnM45");

                ECR.SlipDocCharLineLength = 32;
                ECR.SlipDocTopMargin = 0;
                ECR.SlipDocLeftMargin = 1;
                ECR.SlipDocOrientation = 0;

                ECR.DeviceEnabled = 1;

                if (ECR.GetStatus()){
                    alert("Не получилось соединиться с ККМ!");
                    ECR.DeviceEnabled = 0;
                    window.close(); 
                } else {
                    ECR.Password = 30;
                    ECR.Mode = 3;
                    ECR.SetMode();
                    ECR.ReportType = 1;
                    ECR.Report();
                    ECR.Beep();
                    ECR.DeviceEnabled = 0;
                    window.close(); 
                };';

        return '<script>'.$print.'</script>';

    }

    public function actionPrint()
    {
        $this->enableCsrfValidation = false;
        
        $orderModel = $this->module->orderModel;
        $orderElementModel = $this->module->orderElementModel;
        
        $order = $orderModel::find()->orderBy('id DESC')->limit(1)->one();
        $orderElements = $orderElementModel::find()->where(['order_id' => $order->id])->all();
        $paymentType = $order->getPaymentType()->one()->name;
        $seller = \Yii::$app->user->getIdentity();

        $checkPositions = [];
        
        $checkInfo = [
            'paymentType' => $paymentType,
            'checkType' => 'ПРИХОД',
            'checkName' => 'Касоовый чек',
            'seller' => $seller->username,
            'summ' => $order->cost,
        ];

        foreach ($orderElements as $orderElement) {
            $checkPositions[] = [
                'name' => $orderElement->getModel()->name,
                'price' => $orderElement->price,
                'quantity' => $orderElement->count,
            ];
        }
        $print = '
            ECR = new ActiveXObject("AddIn.FPrnM45");

            ECR.SlipDocCharLineLength = 32;
            ECR.SlipDocTopMargin = 0;
            ECR.SlipDocLeftMargin = 1;
            ECR.SlipDocOrientation = 0;

            ECR.DeviceEnabled = 1;

            if (ECR.GetStatus()){
                alert("Не получилось соединиться с ККМ!");
                ECR.DeviceEnabled = 0;
                window.close(); 
            } else {
                ECR.Password = 30;
                ECR.Mode = 1;
                ECR.SetMode();
                ECR.CheckType = 1;
                ECR.BeginDocument();
                ECR.Alignment = 1;
                ECR.Caption = "------------------------------";
                ECR.PrintString();
                ECR.Alignment = 1;
                ECR.Caption = "'.$checkInfo['checkName'].'";
                ECR.PrintString();
                ECR.Alignment = 2;
                ECR.TextWrap = 2;
                ECR.Caption = "Кассир: '.$checkInfo['seller'].'";
                ECR.AddField();
                ECR.PrintField();
                ECR.Alignment = 0;
                ECR.Caption = "'.$checkInfo['checkType'].'";
                ECR.PrintString();';
        foreach ($checkPositions as $checkPosition) {
            $print .= '
                    ECR.TextWrap = 2;
                    ECR.Name = "'.$checkPosition['name'].'";
                    ECR.Price = '.(int)$checkPosition['price'].';
                    ECR.Quantity = '.(int)$checkPosition['quantity'].';
                    ECR.Registration();';
        };
        $print .= '
                    ECR.Summ = '.$checkInfo['summ'].';
                    ECR.TypeClose = 0;
                    ECR.Payment();
                    ECR.CloseCheck();
                    ECR.DeviceEnabled = 0;
                    window.close(); 
                };';

        return '<script>'.$print.'</script>';
    }
}
