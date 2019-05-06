<?php
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
        if ($sign == $_REQUEST["sign"]) {
            if ($_REQUEST["returncode"] == "00") {
                file_put_contents("success111.txt",$_REQUEST["returncode"]."\n", FILE_APPEND);
                $host='127.0.0.1';

                $user='paimai3';

                $password='paimai3';

                $dbName='paimai3';

                $link=new mysqli($host,$user,$password,$dbName);

                if($link->connect_error){
                    file_put_contents("success111.txt","000"."\n", FILE_APPEND);
                    die("连接失败：".$link->connect_error);

                }else{
                    $sql="select * from qw_attendance_log";
                    file_put_contents("success111.txt","111"."\n", FILE_APPEND);
                    $res=$link->query($sql);
                    file_put_contents("success111.txt","112"."\n", FILE_APPEND);

                    file_put_contents("success111.txt","113"."\n", FILE_APPEND);
                    $sql = "UPDATE `qw_logistics` SET `status`='2' WHERE ( bianhao= '".$returnArray['orderid']." ')";

                    $link->query($sql);
                    file_put_contents("success111.txt","114"."\n", FILE_APPEND);
                    file_put_contents("success111.txt",$returnArray['orderid']."\n", FILE_APPEND);
                    $sql = "SELECT * FROM `qw_logistics` WHERE ( bianhao='".$returnArray['orderid']."' ) LIMIT 1";

                    $order = $link->query($sql);
                    $order = mysql_fetch_assoc($order);
                    $str = var_export($order,true);

                    file_put_contents("success111.txt",$str."\n", FILE_APPEND);
                    file_put_contents("success111.txt","115"."\n", FILE_APPEND);
                      file_put_contents("success111.txt","222"."\n", FILE_APPEND);
                    $sql = "SELECT * FROM `qw_shop` WHERE ( id='".$order['sid']."' ) LIMIT 1";

                    $shop = $link->query($sql);
                    file_put_contents("success111.txt","331"."\n", FILE_APPEND);
                    $sql = "UPDATE `qw_user` SET `freeze`=freeze-".$shop['guaranty']." WHERE ( id='".$order['uid']."' )";

                    $link->query($sql);

                    $sql = "UPDATE `qw_user` SET `guaranty`=guaranty+".$shop['guaranty']." WHERE ( id='".$order['uid']."' )";
                    file_put_contents("success111.txt","332"."\n", FILE_APPEND);
                    $link->query($sql);
                    $time = time();
                    file_put_contents("success111.txt","3321"."\n", FILE_APPEND);
                    $sql = "INSERT INTO `qw_account` (`user_id`,`time`,`amount`,`type`,`mold`) VALUES ('".$order['uid']."','".$time."','".$shop['guaranty']."','9','0')";
                    $link->query($sql);
                    file_put_contents("success111.txt","3322"."\n", FILE_APPEND);
                    $sql = "INSERT INTO `qw_account` (`user_id`,`time`,`amount`,`type`,`mold`) VALUES ('".$order['uid']."','".$time."','".$shop['guaranty']."','11','0')";
                    $link->query($sql);
                    file_put_contents("success111.txt","333"."\n", FILE_APPEND);
                }


                   $str = "交易成功！订单号：".$_REQUEST["orderid"];
                   file_put_contents("success.txt",$str."\n", FILE_APPEND);
                   exit("ok");
            }
        }
?>