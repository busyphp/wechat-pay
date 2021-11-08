<?php

namespace BusyPHP\wechat\pay\native;

use BusyPHP\wechat\pay\WeChatPayRefund;

/**
 * 微信Native支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:02 WeChatNativePayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_4
 */
class WeChatNativePayRefund extends WeChatPayRefund
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