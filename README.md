微信支付模块
===============

## 说明

用于BusyPHP的微信支付，支持公众号端、H5端、APP端、native端支付/退款

## 安装
```
composer require busyphp/wechat-pay
```

## 配置 `config/extend/wechat.php`

```php
<?php
return [
    // 支付配置
    'pay'    => [
        
        // 微信内部JS支付
        //'js'     => [
        //    'type'          => PayType::WECHAT_JS,
        //    'app_id'        => '',
        //    'pay_key'       => '',
        //    'mch_id'        => '',
        //    'ssl_cert_path' => app()->getRootPath() . 'config/cert/wechat/apiclient_cert.pem',
        //    'ssl_key_path'  => app()->getRootPath() . 'config/cert/wechat/apiclient_key.pem',
        //    'ca_cert_path'  => app()->getRootPath() . 'config/cert/wechat/rootca.pem',
        //],
        
        
        // 微信H5支付
        // 'h5'     => [
        //     'type'          => '',
        //     'app_id'        => '',
        //     'pay_key'       => '',
        //     'mch_id'        => '',
        //     'ssl_cert_path' => app()->getRootPath() . 'config/cert/wechat/apiclient_cert.pem',
        //     'ssl_key_path'  => app()->getRootPath() . 'config/cert/wechat/apiclient_key.pem',
        //     'ca_cert_path'  => app()->getRootPath() . 'config/cert/wechat/rootca.pem',
        // ],
        
        
        // 扫码支付
        // 'native' => [
        //     'type'          => '',
        //     'app_id'        => '',
        //     'pay_key'       => '',
        //     'mch_id'        => '',
        //     'ssl_cert_path' => app()->getRootPath() . 'config/cert/wechat/apiclient_cert.pem',
        //     'ssl_key_path'  => app()->getRootPath() . 'config/cert/wechat/apiclient_key.pem',
        //     'ca_cert_path'  => app()->getRootPath() . 'config/cert/wechat/rootca.pem',
        // ],
        
        
        // APP端支付
        //'app'    => [
        //    'type'          => PayType::WECHAT_APP,
        //    'app_id'        => '',
        //    'pay_key'       => '',
        //    'mch_id'        => '',
        //    'ssl_cert_path' => app()->getRootPath() . 'config/cert/wechat/apiclient_cert.p12',
        //    'ssl_key_path'  => app()->getRootPath() . 'config/cert/wechat/apiclient_key.pem',
        //    'ca_cert_path'  => app()->getRootPath() . 'config/cert/wechat/rootca.pem',
        //],
        
        
        // 小程序端支付
        //'mini'    => [
        //    'type'          => PayType::WECHAT_APP,
        //    'app_id'        => '',
        //    'pay_key'       => '',
        //    'mch_id'        => '',
        //    'ssl_cert_path' => app()->getRootPath() . 'config/cert/wechat/apiclient_cert.p12',
        //    'ssl_key_path'  => app()->getRootPath() . 'config/cert/wechat/apiclient_key.pem',
        //    'ca_cert_path'  => app()->getRootPath() . 'config/cert/wechat/rootca.pem',
        //]
    ]
];
```

## 配置 `config/extend/trade.php`
```php
<?php
use BusyPHP\trade\defines\PayType;
use BusyPHP\wechat\pay\WeChatPay;

return [
    // 支付接口绑定
    'apis'            => [
        PayType::WECHAT_JS => WeChatPay::js(),
        PayType::WECHAT_H5 => WeChatPay::h5(),
        PayType::WECHAT_APP => WeChatPay::app(),
        PayType::WECHAT_MINI => WeChatPay::mini(),
        PayType::WECHAT_NATIVE => WeChatPay::native(),
    ]
];
```