<?php

namespace BusyPHP\wechat\pay\mini;

use BusyPHP\wechat\pay\WeChatPayQueryOrder;

/**
 * 微信小程序支付查询订单接口
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:49 WeChatMiniPayQueryOrder.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_2
 */
class WeChatMiniPayQueryOrder extends WeChatPayQueryOrder
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