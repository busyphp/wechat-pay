<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\helper\util\Str;
use BusyPHP\trade\interfaces\PayCreate;
use BusyPHP\trade\interfaces\PayCreateSyncReturn;
use BusyPHP\trade\model\pay\TradePayField;
use BusyPHP\wechat\pay\WeChatPayException;
use BusyPHP\wechat\pay\WeChatPay;

/**
 * 微信JS SDK 支付下单
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:16 下午 WeChatJSPayCreate.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1
 */
class WeChatJSPayCreate extends WeChatPay implements PayCreate
{
    protected $apiUrl = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    
    protected $params = [];
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
    }
    
    
    /**
     * 设置交易信息
     * @param TradePayField $tradeInfo
     */
    public function setTradeInfo(TradePayField $tradeInfo)
    {
        // 商家平台订单号
        $this->params['out_trade_no'] = $tradeInfo->payTradeNo;
        
        // 支付金额
        $this->params['total_fee'] = $tradeInfo->price * 100;
        
        // 商品描述
        $this->params['body'] = Str::cut($tradeInfo->title, 30);
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
     * @return array
     * @throws WeChatPayException
     */
    public function create()
    {
        $this->params['openid']           = defined('WECHAT_OPENID') ? WECHAT_OPENID : '';
        $this->params['appid']            = $this->appId;
        $this->params['mch_id']           = $this->mchId;
        $this->params['nonce_str']        = Str::random(32);
        $this->params['spbill_create_ip'] = $this->request->ip();
        $this->params['trade_type']       = 'JSAPI';
        $this->params['sign_type']        = 'MD5';
        $this->params['device_info']      = 'WEB';
        $this->params['sign']             = self::createSign(self::createSignTemp($this->params, 'sign'), $this->payKey);
        $result                           = $this->request();
        
        // 构造签名参数
        $params = [
            'appId'     => $result['appid'],
            'nonceStr'  => Str::random(32),
            'timeStamp' => trim(time()),
            'package'   => "prepay_id={$result['prepay_id']}",
            'signType'  => 'MD5',
        ];
        
        $params['paySign'] = self::createSign(self::createSignTemp($params, 'sign'), $this->payKey);
        
        return $params;
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