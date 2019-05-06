<?php
/**
 * Created by PhpStorm.
 * User: f
 * Date: 2019/4/11
 * Time: 11:24
 */

namespace Home\Controller;


class ChongzhiController extends ComController
{
    
    public function show()
    {
     
        $this->display('Order/chongzhi');
    }

    public function addChongzhi()
    {
        $money = I("post.money");
        $chongzhi['amount'] = $money;
        $chongzhi['code'] = 'E'.date("YmdHis").rand(100000,9999999);
        $chongzhi['uid'] = session('hid');
        $chongzhi['status'] = 1;
        M('chongzhi')->data($chongzhi)->add();
//        $data['code'] = 1;
//        $data['data'] = success;
//        $this->ajaxReturn($data);
        $uri ="http://api.rg92q.cn/Pay_Index.html";
// 參数数组

        $pay_memberid = "10091";   //商户ID
        $pay_orderid = $chongzhi['code'];    //订单号
        $pay_amount = $money;    //交易金额
        $pay_applydate = date("Y-m-d H:i:s");  //订单时间
        $pay_notifyurl = "http://www.fnvig.cn/index.php/Home/Chongzhi/commit.html";   //服务端返回地址
        $pay_callbackurl = "http://www.fnvig.cn";  //页面跳转返回地址
        $pay_bankcode = "917"; //
        $Md5key = "wtxemijw85ugrqzng7s1lf01niz69qg4";   //密钥
        $data = array (
            "pay_memberid" => $pay_memberid,
            "pay_orderid" => $pay_orderid,
            "pay_amount" => $pay_amount,
            "pay_applydate" => $pay_applydate,
            "pay_bankcode" => $pay_bankcode,
            "pay_notifyurl" => $pay_notifyurl,
            "pay_callbackurl" => $pay_callbackurl,
// 'password' => 'password'
        );

        ksort($data);
        $md5str = "";
        foreach ($data as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
//echo($md5str . "key=" . $Md5key);
        $sign = strtoupper(md5($md5str . "key=" . $Md5key));
        $data["pay_md5sign"] = $sign;
        $data['pay_attach'] = "1234|456";
        $data['pay_productname'] ='保证金充值';


        $ch = curl_init ();
// print_r($ch);
        curl_setopt ( $ch, CURLOPT_URL, $uri );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $return = curl_exec ( $ch );
        curl_close ( $ch );
      
        $data['code'] = 1;
        $data['data'] = $return;

        $this->ajaxReturn($data);

    }

    public function commit()
    {
        $returnArray = array( // 返回字段
            "memberid" => $_REQUEST["memberid"], // 商户ID
            "orderid" =>  $_REQUEST["orderid"], // 订单号
            "amount" =>  $_REQUEST["amount"], // 交易金额
            "datetime" =>  $_REQUEST["datetime"], // 交易时间
            "transaction_id" =>  $_REQUEST["transaction_id"], // 支付流水号
            "returncode" => $_REQUEST["returncode"],
        );
        $md5key = "wtxemijw85ugrqzng7s1lf01niz69qg4";
        ksort($returnArray);
        reset($returnArray);
        $md5str = "";
        foreach ($returnArray as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign = strtoupper(md5($md5str . "key=" . $md5key));
        file_put_contents("success1.txt",$sign."\n".$_REQUEST['sign']."\n", FILE_APPEND);
        if ($sign == $_REQUEST["sign"]) {
            if ($_REQUEST["returncode"] == "00") {

                file_put_contents("success.txt","1111big"."\n", FILE_APPEND);
               $chongzhi = M('chongzhi')->where('code="'.$returnArray['orderid'].'"')->find();
               M('user')->where('id='.$chongzhi['uid'])->setInc('guaranty',$returnArray['amount']);
                getAccount($chongzhi['uid'],time(),$returnArray['amount'],1,0);

                exit("OK");
            }
        }
    }


}