<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 智付通
    |--------------------------------------------------------------------------
    |
    | 智付通金流相關設定參數
    |
    */
    'MerchantID' => env('SPGATEWAY_MERCHANTID'),                      //required 商店代號 Varchar(15)
    'HashKey' => env('SPGATEWAY_HASHKEY'),
    'HashIV' => env('SPGATEWAY_HASHIV'),
    'ServiceURL' => env('SPGATEWAT_SERVICE_URL'),

    'Version' => '1.4',                                 //串接程式版本 Varchar(5)
    'RespondType' => 'JSON',                            //回傳格式 Varchar(6) JSON 或是 String
    'LangType' => '',                                   //語系 en 繁體中文版參數為 zh-tw  預設為繁體中文版, 設定的話鎖死語系 內容會自動讀取語言
    'TradeLimit' => '600',                              //限制交易的秒數,當秒數倒數至 0 時,交 易當做失敗。 Int(3)  60~900
    'ExpireDate' => '',                                 //繳費有效期限  Varchar(10)  date('Ymd') 系統預設為 7 天 可接受最大值為 180 天。

    //支付完成 返回商店網址 Varchar(50) 交易完成後,以 Form Post 方式導回商店頁面。
    //若為空值,交易完成後,消費者將停留在 智付通付款或取號完成頁面。只接受 80 與 443 Port。,
    'ReturnURL' => env('FRONTEND_URL') . 'orders/result',

    //支付通知網址 Varchar(50) 只接受 80 與 443 Port。 付款成功回傳網址
    'NotifyURL' => env('API_URL') . 'orders/complete/spgateway/',

    //ReturnURL 與 NotifyURL 不可設定相同避免誤判 影響帳務正確性

    //商店取號網址  Varchar(50) 若為空值,則會顯示取號結果在智 付通頁面。
    'CustomerURL' => '',

    //支付取消 返回商店網址  Varchar(50) 當交易取消時,平台會出現返回鈕,使消 費者依以此參數網址返回商店指定的頁面。 2.此參數若為空值時,則無返回鈕。
    'ClientBackURL' => env('FRONTEND_URL'),

    'EmailModify' => env('SPGATEWAY_EMAILMODIFY', 0), //付款人電子信箱是否開放修改 Int(1) 付款人電子信箱欄位 是否開放讓付款人修改。1= 可修改/0= 不可修改 預設為可修改
    'LoginType' => env('SPGATEWAY_LOGINTYPE', 0), //required 智付通會員 Int(1) 1'=>須要登入智付通會員 0'=>不須登入智付通會員

    //付費方式啟用
    'CREDIT' => env('SPGATEWAY_CREDIT', 0), //信用卡 一次付清啟用 Int(1) 設定是否啟用信用卡一次付清支付方式。 1=啟用 0 或者未有此參數=不啟用
    'ANDROIDPAY' => env('SPGATEWAY_ANDROIDPAY', 0), //google pay 1=啟用, 0 或者未有此參數=不啟用
    'SAMSUNGPAY' => env('SPGATEWAY_SAMSUNGPAY', 0), //samsung pay 1=啟用, 0 或者未有此參數=不啟用
    'InstFlag' => env('SPGATEWAY_INSTFLAG', 0), //信用卡 分期付款啟用 Varchar(18) 3=分 3 期功能 6=分 6 期功能 12=分 12 期功能 18=分 18 期功能 24=分 24 期功能 30=分 30 期功能 啟多期別時,  形)分隔,例如:3,6,12,代表開啟 分 3、6、12 期的功能。 欄位值=0或無值時,即代表不開啟分期。
    'CreditRed' => env('SPGATEWAY_CREDITRED', 0), //信用卡 紅利啟用 Int(1) 是否啟用信用卡紅利支付方式。 1=啟用 0 或者未有此參數=不啟用
    'UNIONPAY' => env('SPGATEWAY_UNIONPAY', 0), //信用卡 銀聯卡啟用  Int(1) 設定是否啟用銀聯卡支付方式。1=啟用 0 或者未有此參數=不啟用
    'WEBATM' => env('SPGATEWAY_WEBATM', 0), //WEBATM 啟用 Int(1)  1=啟用 0 或者未有此參數=不啟用
    'VACC' => env('SPGATEWAY_VACC', 1), //ATM 轉帳 Int(1)
    'CVS' => env('SPGATEWAY_CVS', 0), // 超商代碼繳費 Int(1) 1=啟用, 0 或者未有此參數=不啟用 金額須大於30 小於2萬
    'BARCODE' => env('SPGATEWAY_BARCODE', 0), //超商條碼繳費 Int(1) 1=啟用, 0 或者未有此參數=不啟用 金額須大於20 小於4萬
    'P2G' => env('SPGATEWAY_P2G', 0), //Pay2go 電子錢 包啟用 1=啟用, 0 或者未有此參數=不啟用
    'CVSCOM' => env('SPGATEWAY_CVSCOM', 0), //超商取貨付款 啟用 使用前,須先登入智付通會員專區啟用物 流並設定退貨門市與取貨人相關資訊。1=>超商取貨不付款  2=>超商取貨付款  3=>超商取貨不付款及超商取貨付款 0 或者未有此參數,即代表不開啟。 2.當該筆訂單金額小於 30 元或大於 2 萬元 時,即使此參數設定為啟用,MPG 付款頁 面仍不會顯示此支付方式選項。
];
