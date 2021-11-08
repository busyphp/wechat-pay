<?php

namespace BusyPHP\wechat\pay\app;

use BusyPHP\wechat\pay\WeChatPayRefund;

/**
 * 微信App支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:00 WeChatAppPayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_4&index=6
 */
class WeChatAppPayRefund extends WeChatPayRefund
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