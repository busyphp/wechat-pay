<?php

namespace BusyPHP\wechat\pay;

use BusyPHP\trade\interfaces\PayRefundNotify;
use BusyPHP\trade\interfaces\PayRefundNotifyResult;
use think\Response;
use Throwable;

/**
 * 支付退款异步通知处理类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午1:02 WeChatPayRefundNotify.php $
 */
abstract class WeChatPayRefundNotify extends WeChatPay implements PayRefundNotify
{
    private $requestString;
    
    private $requestParams;
    
    private $refundNo;
    
    private $reqInfo;
    
    
    /**
     * WeChatH5PayRefundNotify constructor.
     * @throws WeChatPayException
     */
    public function __construct()
    {
        parent::__construct();
        
        $key                 = strtolower(md5($this->payKey));
        $xml                 = file_get_contents('php://input');
        $this->requestString = $xml . ', KEY: ' . $key;
        $this->requestParams = self::xmlToArray($xml);
        
        // 执行aes-256-ecb解密
        $reqInfo = $this->requestParams['req_info'];
        $reqInfo = base64_decode($reqInfo);
        $reqInfo = openssl_decrypt($reqInfo, 'aes-256-ecb', $key, OPENSSL_RAW_DATA);
        $reqInfo = self::xmlToArray($reqInfo);
        
        $this->reqInfo  = $reqInfo;
        $this->refundNo = $this->reqInfo['out_refund_no'];
        if (!$this->reqInfo) {
            throw new WeChatPayException('无法解密reqInfo');
        }
    }
    
    
    /**
     * 执行校验
     * @return PayRefundNotifyResult
     */
    public function notify() : PayRefundNotifyResult
    {
        $res = new PayRefundNotifyResult();
        $res->setRefundNo($this->refundNo);
        $res->setApiRefundNo($this->reqInfo['refund_id']);
        $res->setPayTradeNo($this->reqInfo['out_trade_no']);
        $res->setPayApiTradeNo($this->reqInfo['transaction_id']);
        $res->setRefundAccount($this->reqInfo['refund_recv_accout']);
        $res->setStatus(true);
        
        if ($this->reqInfo['refund_status'] != 'SUCCESS') {
            $res->setStatus(false);
            $res->setErrMsg($this->reqInfo['refund_status'] == 'REFUNDCLOSE' ? '退款关闭' : '退款异常');
        }
        
        return $res;
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
     * @param bool $status
     * @return Response
     */
    public function onSuccess(bool $status) : Response
    {
        return Response::create(static::arrayToXml([
            'return_code' => 'SUCCESS',
            'return_msg'  => 'OK'
        ]))->contentType('text/plain');
    }
    
    
    /**
     * 获取请求参数字符
     * @return string
     */
    public function getRequestSourceParams() : string
    {
        return $this->requestString;
    }
    
    
    public function getRequestParams() : array
    {
        return $this->requestParams;
    }
}