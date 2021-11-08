<?php

namespace BusyPHP\wechat\pay\native;

use BusyPHP\wechat\pay\WeChatPayQueryOrder;

/**
 * 微信Native支付查询订单接口
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:50 WeChatNativePayQueryOrder.php $
 */
class WeChatNativePayQueryOrder extends WeChatPayQueryOrder
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'native';
    }
}