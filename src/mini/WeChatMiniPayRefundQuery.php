<?php

namespace BusyPHP\wechat\pay\mini;

use BusyPHP\wechat\pay\WeChatPayRefundQuery;

/**
 * 查询退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/10 下午9:53 WeChatMiniPayRefundQuery.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_5
 */
class WeChatMiniPayRefundQuery extends WeChatPayRefundQuery
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