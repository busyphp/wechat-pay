<?php

namespace BusyPHP\wechat\pay\h5;

use BusyPHP\wechat\pay\WeChatPayRefundQuery;

/**
 * 查询退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/10 下午9:53 WeChatH5PayRefundQuery.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=9_5&index=5
 */
class WeChatH5PayRefundQuery extends WeChatPayRefundQuery
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