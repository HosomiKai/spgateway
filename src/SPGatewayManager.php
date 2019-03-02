<?php

namespace hosomikai\spgateway;

class SPGatewayManager
{
    private $_instance = null;
    
    public function __construct()
    {
        $this->_instance = app(SPGateway::class);
        $this->_instance->ServiceURL = config('spgateway.ServiceURL');
        $this->_instance->HashKey    = config('spgateway.HashKey');
        $this->_instance->HashIV     = config('spgateway.HashIV');
        $this->_instance->MerchantID = config('spgateway.MerchantID');
    
        $this->_instance->Version = config('spgateway.Version');
        $this->_instance->RespondType = config('spgateway.RespondType');
        $this->_instance->LangType = config('spgateway.LangType') ?: app()->getLocale();

        //設定相關
        $this->_instance->Send['TradeLimit'] =  config('spgateway.TradeLimit');
        $this->_instance->Send['ExpireDate'] =  config('spgateway.ExpireDate');
        $this->_instance->Send['ReturnURL'] =  config('spgateway.ReturnURL');
        $this->_instance->Send['NotifyURL'] =  config('spgateway.NotifyURL');
        $this->_instance->Send['CustomerURL'] =  config('spgateway.CustomerURL');
        $this->_instance->Send['ClientBackURL'] =  config('spgateway.ClientBackURL');
        //設定相關
        $this->_instance->Send['EmailModify'] = config('spgateway.EmailModify');
        $this->_instance->Send['LoginType'] = config('spgateway.LoginType');
        //付款方式相關
        $this->_instance->Send['CREDIT'] = config('spgateway.CREDIT');
        $this->_instance->Send['InstFlag'] = config('spgateway.InstFlag');
        $this->_instance->Send['CreditRed'] = config('spgateway.CreditRed');
        $this->_instance->Send['UNIONPAY'] = config('spgateway.UNIONPAY');
        $this->_instance->Send['WEBATM'] = config('spgateway.WEBATM');
        $this->_instance->Send['VACC'] = config('spgateway.VACC');
        $this->_instance->Send['CVS'] = config('spgateway.CVS');
        $this->_instance->Send['BARCODE'] = config('spgateway.BARCODE');
        $this->_instance->Send['P2G'] = config('spgateway.P2G');
        $this->_instance->Send['CVSCOM'] = config('spgateway.CVSCOM');
    }
    public function instance()
    {
        return $this->_instance;
    }
    public function i()
    {
        return $this->_instance;
    }
}
