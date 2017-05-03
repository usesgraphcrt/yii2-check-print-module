# yii2-check-print-module
Модуль печати чеков и работы со сменой для ккм


Данный модуль предназначен для работы с ккм на базе драйвера "АТОЛ";

## Подключение и настройка

Выполнить команду:
```
php composer.phar require --prefer-dist usesgraphcrt/yii2-check-print-module "*"
```

либо добавить в composer.json в секцию require:

```
"usesgraphcrt/yii2-check-print-module": "*"
```

Для начала работы с модулем добавить в конфиг в секцию модулей:

```php
'modules' => [
        ...
        'check-print' => [
            'class' => \usesgraphcrt\checkPrint\Module::className(),
            'orderModel' => 'namespace модели заказов',
            'orderElementModel' => 'namespace модели элементов заказа',
            'adminRoles' => [//роли, которые имеют доступ к печати],
            'organizationInn' => 'some Inn', //ИНН организации (используется для печати на чеке)
            'organizationAddress' => 'address', //так же используется для печати на чеке
            'examCheckSite' => 'siteUrl', //адрес сайта, на котором можно проверить достоверность чека
        ],
    ],
```
Для того, чтобы работала печать чека, необходимо зарегестрировать AssetBundle модуля в Вашем layout'e добавив строку:
```php
usesgraphcrt\check-print\PrintAsset::register($this);
```
