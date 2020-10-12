<?php

namespace BusyPHP\wechat\pay\h5;

use BusyPHP\trade\interfaces\PayCreate;
use BusyPHP\trade\interfaces\PayCreateSyncReturn;
use BusyPHP\trade\model\pay\TradePayField;
use BusyPHP\wechat\pay\WeChatPayException;
use BusyPHP\wechat\pay\WeChatPay;
use think\helper\Str;


/**
 * 微信扫码支付下单
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:03 下午 WeChatH5PayCreate.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_1
 */
class WeChatH5PayCreate extends WeChatPay implements PayCreate
{
    protected $apiUrl = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    
    protected $params = [];
    
    /**
     * @var TradePayField
     */
    protected $tradeInfo = null;
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'h5';
    }
    
    
    /**
     * 设置交易信息
     * @param TradePayField $tradeInfo
     */
    public function setTradeInfo(TradePayField $tradeInfo)
    {
        $this->tradeInfo = $tradeInfo;
        
        // 商家单号
        $this->params['out_trade_no'] = $tradeInfo->payTradeNo;
        
        // 支付金额
        $this->params['total_fee'] = $tradeInfo->price * 100;
        
        // 支付描述
        $this->params['body'] = $tradeInfo->title;
    }
    
    
    /**
     * 设置附加数据会原样返回
     * @param string $attach
     */
    public function setAttach(string $attach)
    {
        $this->params['attach'] = $attach;
    }
    
    
    /**
     * 设置异步回调地址
     * @param string $notifyUrl
     */
    public function setNotifyUrl(string $notifyUrl)
    {
        $this->params['notify_url'] = $notifyUrl;
    }
    
    
    /**
     * 设置同步回调地址
     * @param string $returnUrl
     * @deprecated 微信H5支付无效
     */
    public function setReturnUrl(string $returnUrl)
    {
    }
    
    
    /**
     * 设置商品展示地址
     * @param string $showUrl
     * @deprecated 微信H5支付无效
     */
    public function setShowUrl(string $showUrl)
    {
    }
    
    
    /**
     * 执行下单
     * @return string 要跳转的支付链接
     * @throws WeChatPayException
     */
    public function create()
    {
        $this->params['appid']            = $this->appId;
        $this->params['mch_id']           = $this->mchId;
        $this->params['nonce_str']        = Str::random(32);
        $this->params['spbill_create_ip'] = $this->request->ip();
        $this->params['trade_type']       = 'MWEB';
        $this->params['sign_type']        = 'MD5';
        $this->params['device_info']      = 'WEB';
        $this->params['product_id']       = $this->params['out_trade_no'];
        $this->params['scene_info']       = json_encode([
            'h5_info' => [
                'type'     => 'Wap',
                'wap_url'  => $this->request->getWebUrl(true),
                'wap_name' => $this->app->config->get('user.public.title')
            ]
        ], JSON_UNESCAPED_UNICODE);
        $this->params['sign']             = self::createSign(self::createSignTemp($this->params, 'sign'), $this->payKey);
        $result                           = $this->request();
        
        return $result['mweb_url'];
    }
    
    
    /**
     * 解析同步返回结果
     * @return PayCreateSyncReturn
     */
    public function syncReturn() : PayCreateSyncReturn
    {
        return new PayCreateSyncReturn();
    }
}