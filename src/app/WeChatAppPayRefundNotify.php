<?php

namespace BusyPHP\wechat\pay\app;

use BusyPHP\wechat\pay\WeChatPayRefundNotify;

/**
 * 微信App支付退款异步通知处理类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:05 WeChatAppPayRefundNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_16&index=11
 */
class WeChatAppPayRefundNotify extends WeChatPayRefundNotify
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey() : string
    {
        return 'app';
    }
}