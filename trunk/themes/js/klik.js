$(document).ready(function(){
	//disbaling some functions for Internet Explorer
	//if($.browser.msie)
	//{
	//	//$('#is-ajax').prop('checked',false);
	//	//$('#for-is-ajax').hide();
	//	//$('#toggle-fullscreen').hide();
	//	//$('.login-box').find('.input-large').removeClass('span10');
	//	
	//}
	
	//highlight current / active link
	$('ul.main-menu li a').each(function(){
		if($($(this))[0].href==String(window.location))
			$(this).parent().addClass('active');
	});
	
	//ajaxify menus
	$('a.ajax-link').click(function(e){
		//if($.browser.msie){
		//e.which=1;
		//console.log($.browser.msie)
		//}
		//if(e.which!=1 || $(this).parent().hasClass('active')) return;
		if(e.preventDefault()) e.preventDefault = false;
		//alert(navigator.userAgent)
		//if($('.btn-navbar').is(':visible'))
		//{
		//	$('.btn-navbar').click();
		//}
		//$('#loading').remove();
		//$('#content').fadeOut().parent().append('<div id="loading" class="center">Loading...<div class="center"></div></div>');
		var $clink=$(this);
		////History.pushState(null, null, clink.attr('href'));
		$('ul.main-menu li.active').removeClass('active');
		$clink.parent('li').addClass('active');	
		////alert(clink.attr('href'))
		
		var url = $clink.attr('name');
		var posting = $.post(url);
		posting.done(function(data){
			//var res = $.parseJSON(data);
			var res = data;
			var content = $("#content");
			content.html(res);
			//$('.datepicker').datepicker();
			//$('.cleditor').cleditor();
			//if(res['status']=='error'){
			//	//content.addClass("alert alert-error");
			//}else if(res['status']=='success'){
			//	//content.addClass("alert alert-success");
			//	//$('#loading').remove();
			//	content.html(res);
			//}else{
			//	content.addClass("alert alert-error");
			//	content[0].innerHTML = 'Something error with your sintax! :)';
			//}
		});
	});
	
	//animating menus on hover
	$('ul.main-menu li:not(.nav-header)').hover(function(){
		$(this).animate({'margin-left':'+=5'},300);
	},
	function(){
		$(this).animate({'margin-left':'-=5'},300);
	});
	
	//$(document).ready(function(){
		$('.datepicker').datepicker();
		$('.cleditor').cleditor();
	//});
});