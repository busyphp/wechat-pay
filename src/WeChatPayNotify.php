<?php

namespace BusyPHP\wechat\pay;

use BusyPHP\trade\interfaces\PayNotify;
use BusyPHP\trade\interfaces\PayNotifyResult;
use think\Response;
use Throwable;

/**
 * 支付下单异步通知处理
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:51 WeChatPayNotify.php $
 */
abstract class WeChatPayNotify extends WeChatPay implements PayNotify
{
    protected $requestParams = [];
    
    protected $requestString = '';
    
    protected $tradeNo       = '';
    
    
    /**
     * 获取订单查询类
     * @return WeChatPayQueryOrder
     */
    abstract protected function getQuery() : WeChatPayQueryOrder;
    
    
    /**
     * WeChatAppPayNotify constructor.
     * @throws WeChatPayException
     */
    public function __construct()
    {
        parent::__construct();
        
        $xml                 = file_get_contents('php://input');
        $this->requestString = $xml;
        $this->requestParams = self::xmlToArray($xml);
        $this->tradeNo       = $this->requestParams['out_trade_no'] ?? '';
    }
    
    
    /**
     * 执行校验
     * @return PayNotifyResult
     * @throws WeChatPayException
     */
    public function notify() : PayNotifyResult
    {
        // 验证签名是否合法
        $sign = static::sign(static::temp($this->requestParams, 'sign'), $this->payKey);
        if ($sign != $this->requestParams['sign']) {
            throw new WeChatPayException("签名错误: {$sign}, {$this->requestParams['sign']}");
        }
        
        $queryOrder = $this->getQuery();
        $queryOrder->setPayTradeNo($this->requestParams['transaction_id']);
        $info = $queryOrder->request();
        if ($info['trade_state'] != 'SUCCESS') {
            throw new WeChatPayException("查询支付结果失败: {$info['trade_state']}, {$info['trade_state_desc']}");
        }
        
        $result = new PayNotifyResult();
        $result->setApiTradeNo($this->requestParams['transaction_id']);
        $result->setPayTradeNo($this->tradeNo);
        $result->setApiPrice($this->requestParams['total_fee'] / 100);
        $result->setAttach($this->requestParams['attach'] ?? '');
        $result->setPayType($this->type);
        
        return $result;
    }
    
    
    /**
     * 失败通知
     * @param Throwable $e
     * @return Response
     * @throws WeChatPayException
     */
    public function onError(Throwable $e) : Response
    {
        return Response::create(static::arrayToXml([
            'return_code' => 'FAIL',
            'return_msg'  => $e->getMessage()
        ]))->contentType('text/plain');
    }
    
    
    /**
     * 成功通知
     * @param bool $payStatus true 支付成功，false 之前已支付，属于重复性的操作
     * @return Response
     * @throws WeChatPayException
     */
    public function onSuccess(bool $payStatus) : Response
    {
        return Response::create(static::arrayToXml([
            'return_code' => 'SUCCESS',
            'return_msg'  => 'OK'
        ]))->contentType('text/plain');
    }
    
    
    /**
     * 获取请求参数
     * @return array
     */
    public function getRequestParams() : array
    {
        return $this->requestParams;
    }
    
    
    /**
     * 获取请求参数字符
     * @return string
     */
    public function getRequestSourceParams() : string
    {
        return $this->requestString;
    }
    
    
    /**
     * 获取商户订单号
     * @return string
     */
    public function getPayTradeNo()
    {
        return $this->tradeNo;
    }
}