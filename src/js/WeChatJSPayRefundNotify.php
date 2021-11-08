<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\wechat\pay\WeChatPayRefundNotify;

/**
 * 微信JSSDK支付退款异步通知处理类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:04 WeChatJSPayRefundNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_16&index=10
 */
class WeChatJSPayRefundNotify extends WeChatPayRefundNotify
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
    }
}