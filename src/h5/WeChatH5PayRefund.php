<?php

namespace BusyPHP\wechat\pay\h5;

use BusyPHP\wechat\pay\WeChatPayRefund;

/**
 * 微信H5支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:00 WeChatH5PayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=9_4&index=4
 */
class WeChatH5PayRefund extends WeChatPayRefund
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'h5';
    }
}