/*

 电话号input class="phone"

 使用 onclick="getCode(this,url)"

 */



function getCode(_self,url,mobile){

    //验证

    if(!mobile){

        noty({text: "请输入手机号码！", layout: "center",type: 'warning' ,timeout: 4000});

        return false;

    }

    var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/;

    if(!myreg.test(mobile))

    {

        noty({text: "手机号码格式不正确!", layout: "center",type: 'warning',timeout: 4000});

        return false;

    }

    //倒计时

    $(_self).prop("disabled",true);

    times = 60;

    timerHandle = setInterval(function(){

        times--;

        $(_self).text( "重新发送("+times +")");

        if(times <= 0)

        {

            $(_self).prop("disabled",false);

            $(_self).text("重新发送");

            clearInterval(timerHandle);

            times = 60;

        }

    },1000);

    $.post(url,{phone:mobile,type:2},function(data){
       
       //data = JSON.parse(data);
        if(data['code']){

            noty({text: "发送成功！请注意查收", layout: "center",type: 'success',timeout: 4000});



        }else{

            noty({text: data['msg'], layout: "center",type: 'error',timeout: 4000});



            $(_self).prop("disabled",false);

            $(_self).text("重新发送");

            clearInterval(timerHandle);

            times = 60;

        }

    });

}