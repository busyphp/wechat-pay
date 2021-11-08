<?php

namespace BusyPHP\wechat\pay\mini;

use BusyPHP\wechat\pay\WeChatPayRefund;

/**
 * 微信小程序支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:01 WeChatMiniPayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_4
 */
class WeChatMiniPayRefund extends WeChatPayRefund
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