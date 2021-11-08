<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\wechat\pay\WeChatPayRefund;

/**
 * JSSDK 支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:01 WeChatJSPayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_4
 */
class WeChatJSPayRefund extends WeChatPayRefund
{
    protected $apiUrl = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
    }
}