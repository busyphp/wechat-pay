<?php

namespace BusyPHP\wechat\pay;

use BusyPHP\trade\interfaces\PayRefundNotifyResult;
use BusyPHP\trade\interfaces\PayRefundQuery;
use BusyPHP\trade\interfaces\PayRefundQueryResult;
use BusyPHP\trade\model\refund\TradeRefundField;
use Exception;

/**
 * 退款查询
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:58 WeChatPayRefund.php $
 */
abstract class WeChatPayRefundQuery extends WeChatPay implements PayRefundQuery
{
    protected $apiUrl = 'https://api.mch.weixin.qq.com/pay/refundquery';
    
    
    /**
     * 设置平台退款订单数据对象
     * @param TradeRefundField $info
     */
    public function setTradeRefundInfo(TradeRefundField $info)
    {
        $this->params['transaction_id'] = $info->payApiTradeNo;
        $this->params['out_trade_no']   = $info->orderTradeNo;
        $this->params['out_refund_no']  = $info->refundNo;
        $this->params['refund_id']      = $info->apiRefundNo;
    }
    
    
    /**
     * 执行查询
     * @return PayRefundQueryResult
     * @throws Exception
     */
    public function query() : PayRefundQueryResult
    {
        $notifyResult = new PayRefundNotifyResult();
        $res          = new PayRefundQueryResult($notifyResult);
        
        try {
            $result = $this->request();
            switch (($result['refund_status_0'] ?? '')) {
                // 退款成功
                case 'SUCCESS':
                    $notifyResult->setStatus(true);
                    $notifyResult->setApiRefundNo($result['refund_id_0']);
                    $notifyResult->setRefundAccount($result['refund_recv_accout_0']);
                    
                    foreach ($result as $key => $value) {
                        $res->addDetail($key, $value);
                    }
                break;
                
                // 退款关闭
                case 'REFUNDCLOSE':
                    throw new WeChatPayException('退款关闭，商户发起退款失败');
                break;
                
                // 退款异常
                case 'CHANGE':
                    throw new WeChatPayException('退款异常，退款到银行发现用户的卡作废或者冻结了');
                break;
                
                // 退款中
                case 'PROCESSING':
                default:
                    $notifyResult->setNeedReHandle(true);
            }
        } catch (WeChatPayException $e) {
            if ($e->getErrCode() === 'SYSTEMERROR') {
                $notifyResult->setNeedReHandle(true);
                $notifyResult->setErrMsg($e->getMessage());
            } else {
                throw $e;
            }
        }
        
        return $res;
    }
}