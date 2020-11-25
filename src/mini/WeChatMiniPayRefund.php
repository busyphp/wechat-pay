<?php

namespace BusyPHP\wechat\pay\mini;

use BusyPHP\wechat\pay\js\WeChatJSPayRefund;

/**
 * 微信小程序支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:21 下午 WeChatMiniPayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_4
 */
class WeChatMiniPayRefund extends WeChatJSPayRefund
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'mini';
    }
}