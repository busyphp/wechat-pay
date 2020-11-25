<?php

namespace BusyPHP\wechat\pay\app;

use BusyPHP\wechat\pay\js\WeChatJSPayRefund;

/**
 * 微信App支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:21 下午 WeChatAppPayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_4&index=6
 */
class WeChatAppPayRefund extends WeChatJSPayRefund
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