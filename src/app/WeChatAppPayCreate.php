<?php

namespace BusyPHP\wechat\pay\app;


use BusyPHP\helper\util\Str;
use BusyPHP\trade\interfaces\PayCreate;
use BusyPHP\trade\interfaces\PayCreateSyncReturn;
use BusyPHP\trade\model\pay\TradePayField;
use BusyPHP\wechat\pay\WeChatPayException;
use BusyPHP\wechat\pay\WeChatPay;

/**
 * APP支付下单
 * @author busy^life <busy.life@qq.com>
 * @copyright 2015 - 2018 busy^life <busy.life@qq.com>
 * @version $Id: 2018-04-15 上午10:58 WeChatAppPayCreate.php busy^life $
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1
 */
class WeChatAppPayCreate extends WeChatPay implements PayCreate
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
        return 'app';
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
     * @deprecated 微信APP支付无效
     */
    public function setReturnUrl(string $returnUrl)
    {
    }
    
    
    /**
     * 设置商品展示地址
     * @param string $showUrl
     * @deprecated 微信APP支付无效
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
        $this->params['appid']            = $this->appId;
        $this->params['mch_id']           = $this->mchId;
        $this->params['nonce_str']        = Str::random(32);
        $this->params['spbill_create_ip'] = $this->request->ip();
        $this->params['trade_type']       = 'APP';
        $this->params['sign_type']        = 'MD5';
        $this->params['device_info']      = 'WEB';
        $this->params['sign']             = self::createSign(self::createSignTemp($this->params, 'sign'), $this->payKey);
        $result                           = $this->request();
        
        // 构造签名参数
        $params = [
            'appid'     => $result['appid'],
            'partnerid' => $result['mch_id'],
            'prepayid'  => $result['prepay_id'],
            'noncestr'  => Str::random(32),
            'timestamp' => time(),
            'package'   => "Sign=WXPay",
        ];
        
        return [
            'appId'        => $params['appid'],
            'partnerId'    => $params['partnerid'],
            'prepayId'     => $params['prepayid'],
            'nonceStr'     => $params['noncestr'],
            'timestamp'    => $params['timestamp'],
            'packageValue' => $params['package'],
            'sign'         => self::createSign(self::createSignTemp($params, 'sign'), $this->payKey)
        ];
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