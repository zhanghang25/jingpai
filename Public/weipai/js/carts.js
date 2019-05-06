/*
sumObj====".select_all" 总计
subObj====".carts"      购物车
obj   ====".check"      复选框
*/
function fnSelect(sumObj,subObj,obj){
	sum(sumObj,subObj,obj ,'.count');//计算金额
	$(sumObj+' '+obj).click(function(){
		if ($(this).hasClass('checked')) { //全不选
			$(this).removeClass('checked').html('');
			$(subObj).find(obj).removeClass('checked').html('');
		}else{ //全选
			$(this).addClass('checked').html('&#xe610;');
			$(subObj).find(obj).addClass('checked').html('&#xe610;');
		}
		sum(sumObj,subObj,obj ,'.count');//计算金额
	});

	$(subObj).each(function(){
		var _this=$(this);

		//商品
		_this.find(obj).bind('click',function(){
			var $this=$(this);
			$this.toggleClass('checked');

			if($this.hasClass('checked')){
				$this.addClass('checked').html('&#xe610;');

				var s=true;
				$this.parentsUntil(subObj).parent().find(obj).each(function() {
					if (!$(this).hasClass('checked')) {
						s=false;
						return false;
					}
				});
				if(s){
					$(sumObj+' '+obj).addClass('checked').html('&#xe610;');
				}
			}else{
				$this.removeClass('checked').html('');
				$(sumObj+' '+obj).removeClass('checked').html(''); //取消整体全选
			}

			sum(sumObj,subObj,obj ,'.count');//计算金额
		});

	});

}


//计算金额
function sum(sumObj,subObj,obj, countObj){
	var sum=0;//总金额
	var n=0; //总数

/*	$(subObj).each(function() {
		var subSum=0;//每家店铺金额小计
		var $this=$(this);
		$this.find(obj).each(function(){
			if($(this).hasClass('checked')){
				var price=parseFloat($(this).parent().parent().find(".price").eq(0).text());
				var num=parseInt($(this).parent().parent().find(".num").eq(0).text());
				subSum+=price*num;
				n++;
			}
		});
		sum+=subSum;
	});*/

	$(subObj).find(obj).each(function(){
		if($(this).hasClass('checked')){
			var price=parseFloat($(this).parent().parent().find(".price").eq(0).text());
			var num=parseInt($(this).parent().parent().find(".num").eq(0).text());
			sum+=price*num;
			n++;
		}
	});

	$(sumObj).find(".total").text(sum.toFixed(2));
	$(sumObj).find('.sum_num').text(n);
	$(countObj).find('.sum_num').text(n);
	$(countObj).find('.total').text(sum.toFixed(2));
}


function fnSelect_collect(sumObj,subObj,obj){
	$(sumObj+' '+obj).click(function(){
		if ($(this).hasClass('checked')) { //全不选
			$(this).removeClass('checked').html('');
			$(subObj).find(obj).removeClass('checked').html('');
		}else{ //全选
			$(this).addClass('checked').html('&#xe610;');
			$(subObj).find(obj).addClass('checked').html('&#xe610;');
		}
	});

	$(subObj).each(function(){
		var _this=$(this);

		//商品
		_this.find(obj).bind('click',function(){
			var $this=$(this);
			$this.toggleClass('checked');

			if($this.hasClass('checked')){
				$this.addClass('checked').html('&#xe610;');

				var s=true;
				$this.parentsUntil(subObj).parent().find(obj).each(function() {
					if (!$(this).hasClass('checked')) {
						s=false;
						return false;
					}
				});
				if(s){
					$(sumObj+' '+obj).addClass('checked').html('&#xe610;');
				}
			}else{
				$this.removeClass('checked').html('');
				$(sumObj+' '+obj).removeClass('checked').html(''); //取消整体全选
			}
		});

	});

}