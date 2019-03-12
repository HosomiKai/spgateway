<?php
namespace hosomikai\spgateway;

class SPGateway
{
    public $MerchantID = 'MerchantID';
    public $HashKey = 'HashKey';
    public $HashIV = 'HashIV';
    public $ServiceURL = 'ServiceURL';


    public $Version = '1.4';
    public $RespondType = 'JSON';
    public $LangType = '';

    public $Send = 'Send';
            
    public function __construct()
    {
        $this->Send = array(
            'TimeStamp' => time(),
            //設定相關
            'TradeLimit' => '',
            'ExpireDate' => '',
            'ReturnURL' => '',
            'NotifyURL' => '',
            'CustomerURL' => '',
            'ClientBackURL' => '',
            //訂單相關
            'MerchantOrderNo' => '',
            'Amt' => '',
            'ItemDesc' => '',
            'Email' => '',
            'OrderComment' => '',
            //設定相關
            'EmailModify' => 0,
            'LoginType' => 0,
            //付款方式相關
            'CREDIT' => 0,
            'ANDROIDPAY' => 0,
            'SAMSUNGPAY' => 0,
            'InstFlag' => 0,
            'CreditRed' => '',
            'UNIONPAY' => 0,
            'WEBATM' => 1,
            'VACC' => 1,
            'CVS' => 0,
            'BARCODE' => 0,
            'P2G' => 0,
            'CVSCOM' => 0,
        );
    }

    //產生訂單html code
    public function CheckOutString()
    {
        $arParameters = array_merge(
            [
                'MerchantID' => $this->MerchantID,
                'Version' => $this->Version,
                'LangType' => $this->LangType,
                'RespondType' => $this->RespondType,
            ],
            $this->Send
        );
        return SPGateway_Send::CheckOutString($arParameters, $this->HashKey, $this->HashIV, $this->ServiceURL);
    }
}

class SPGateway_Send
{
    public static function CheckOutString($arParameters = [], $HashKey='', $HashIV='', $ServiceURL='')
    {
        //交易資料經 AES 加密後取得 TradeInfo
        $TradeInfo = SPGateway_Helper::create_mpg_aes_encrypt($arParameters, $HashKey, $HashIV);
        
        //產生檢查碼
        $TradeSha = SPGateway_CheckMacValue::generate($TradeInfo, $HashKey, $HashIV);

        $merchantTradeInfo = array_only($arParameters, ['MerchantID', 'Version']);

        //生成表單，自動送出
        $szHtml = '<!DOCTYPE html>';
        $szHtml .= '<html>';
        $szHtml .= '<head>';
        $szHtml .= '<meta charset="utf-8">';
        $szHtml .= '</head>';
        $szHtml .= '<body>';
        $szHtml .= "<form id=\"__spgatewayForm\" method=\"post\"  action=\"{$ServiceURL}\">";

        foreach ($merchantTradeInfo as $keys => $value) {
            $szHtml .= "<input type=\"hidden\" name=\"{$keys}\" value=\"{$value}\" />";
        }
        $szHtml .= "<input type=\"hidden\" name=\"TradeInfo\" value=\"{$TradeInfo}\" />";
        $szHtml .= "<input type=\"hidden\" name=\"TradeSha\" value=\"{$TradeSha}\" />";
        $szHtml .= '</form>';
        $szHtml .= '<script type="text/javascript">document.getElementById("__spgatewayForm").submit();</script>';
        $szHtml .= '</body>';
        $szHtml .= '</html>';

        return $szHtml;
    }
}


class SPGateway_CheckMacValue
{
    public static function generate($TradeInfo = '', $HashKey = '', $HashIV = '')
    {
        //組成字串
        $sMacValue = "HashKey=$HashKey&$TradeInfo&HashIV=$HashIV";

        //sha256 編碼
        $sMacValue = hash('sha256', $sMacValue);

        //轉大寫
        $TradeSha = strtoupper($sMacValue);

        return $TradeSha;
    }
}

class SPGateway_Helper
{
    /**
     * AES加密.
     *
     * @param string $parameter
     * @param string $key
     * @param string $iv
     *
     * @return string
     */
    public static function create_mpg_aes_encrypt($parameter = '', $key = '', $iv = '')
    {
        $return_str = '';
        if (!empty($parameter)) {
            //將參數經過 URL ENCODED QUERY STRING
            $return_str = http_build_query($parameter);
        }

        return trim(bin2hex(openssl_encrypt(self::addpadding($return_str), 'aes-256-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv)));
    }

    /**
     * AES解密.
     *
     * @param string $parameter
     * @param string $key
     * @param string $iv
     *
     * @return bool|string
     */
    public static function create_aes_decrypt($parameter = '', $key = '', $iv = '')
    {
        return self::strippadding(openssl_decrypt(hex2bin($parameter), 'AES-256-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv));
    }

    public static function addpadding($string, $blocksize = 32)
    {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);

        return $string;
    }

    public static function strippadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);

        if (preg_match("/$slastc{" . $slast . '}/', $string)) {
            $string = substr($string, 0, strlen($string) - $slast);

            return $string;
        }

        return false;
    }
}
