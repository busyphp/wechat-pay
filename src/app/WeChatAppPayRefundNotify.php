<?php

namespace BusyPHP\wechat\pay\app;

use BusyPHP\wechat\pay\js\WeChatJSPayRefundNotify;

/**
 * 微信App支付退款异步通知处理类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:24 下午 WeChatAppPayRefundNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_16&index=11
 */
class WeChatAppPayRefundNotify extends WeChatJSPayRefundNotify
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'app';
    }
}