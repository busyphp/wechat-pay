<?php

namespace BusyPHP\wechat\pay;

use BusyPHP\trade\interfaces\PayCreate;
use BusyPHP\trade\interfaces\PayCreateSyncReturn;
use BusyPHP\trade\model\pay\TradePayInfo;

/**
 * 微信支付下单
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:03 下午 WeChatPayCreate.php $
 */
abstract class WeChatPayCreate extends WeChatPay implements PayCreate
{
    protected $apiUrl = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    
    /**
     * 交易类型
     * @var string
     */
    protected $tradeType;
    
    /**
     * @var string
     */
    protected $deviceInfo;
    
    
    /**
     * 设置交易信息
     * @param TradePayInfo $tradeInfo
     */
    public function setTradeInfo(TradePayInfo $tradeInfo)
    {
        $this->params['out_trade_no'] = $tradeInfo->payTradeNo;
        $this->params['total_fee']    = $tradeInfo->price * 100;
        $this->params['body']         = $tradeInfo->title;
        $this->params['time_start']   = date('YmdHis', $tradeInfo->createTime);
        $this->params['time_expire']  = date('YmdHis', $tradeInfo->invalidTime);
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
     */
    public function setReturnUrl(string $returnUrl)
    {
    }
    
    
    /**
     * 设置商品展示地址
     * @param string $showUrl
     */
    public function setShowUrl(string $showUrl)
    {
    }
    
    
    /**
     * 执行下单
     * @return mixed
     * @throws WeChatPayException
     */
    public function create()
    {
        $this->params['spbill_create_ip'] = $this->request->ip();
        $this->params['trade_type']       = $this->tradeType;
        $this->params['device_info']      = $this->deviceInfo;
        
        return $this->request();
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