<?php

namespace BusyPHP\wechat\pay\h5;

use BusyPHP\app\admin\setting\PublicSetting;
use BusyPHP\wechat\pay\WeChatPayCreate;
use BusyPHP\wechat\pay\WeChatPayException;

/**
 * 微信H5支付下单
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:42 WeChatH5PayCreate.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_1
 */
class WeChatH5PayCreate extends WeChatPayCreate
{
    protected $tradeType  = 'MWEB';
    
    protected $deviceInfo = 'WEB';
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'h5';
    }
    
    
    /**
     * 执行下单
     * @return string 要跳转的支付链接
     * @throws WeChatPayException
     */
    public function create()
    {
        $this->params['product_id'] = $this->params['out_trade_no'];
        $this->params['scene_info'] = json_encode([
            'h5_info' => [
                'type'     => 'Wap',
                'wap_url'  => $this->request->getWebUrl(true),
                'wap_name' => PublicSetting::init()->getTitle()
            ]
        ], JSON_UNESCAPED_UNICODE);
        
        $result = parent::create();
        
        return $result['mweb_url'];
    }
}