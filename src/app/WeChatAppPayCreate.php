<?php

namespace BusyPHP\wechat\pay\app;

use BusyPHP\helper\StringHelper;
use BusyPHP\wechat\pay\WeChatPayCreate;
use BusyPHP\wechat\pay\WeChatPayException;

/**
 * APP支付下单
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:29 WeChatAppPayCreate.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1
 */
class WeChatAppPayCreate extends WeChatPayCreate
{
    protected $tradeType  = 'APP';
    
    protected $deviceInfo = 'WEB';
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'app';
    }
    
    
    /**
     * 执行下单
     * @return array
     * @throws WeChatPayException
     */
    public function create()
    {
        $result = parent::create();
        
        // 构造签名参数
        $params = [
            'appid'     => $result['appid'],
            'partnerid' => $result['mch_id'],
            'prepayid'  => $result['prepay_id'],
            'noncestr'  => StringHelper::random(32),
            'timestamp' => time(),
            'package'   => "Sign=WXPay",
        ];
        
        return [
            'appId'        => $params['appid'],
            'partnerId'    => $params['partnerid'],
            'prepayId'     => $params['prepayid'],
            'nonceStr'     => $params['noncestr'],
            'timestamp'    => $params['timestamp'],
            'packageValue' => $params['package'],
            'sign'         => self::createSign(self::createSignTemp($params, 'sign'), $this->payKey)
        ];
    }
}