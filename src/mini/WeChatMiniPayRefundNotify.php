<?php

namespace BusyPHP\wechat\pay\mini;

use BusyPHP\wechat\pay\WeChatPayRefundNotify;

/**
 * 微信小程序退款异步通知处理类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:04 WeChatMiniPayRefundNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_16&index=10
 */
class WeChatMiniPayRefundNotify extends WeChatPayRefundNotify
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