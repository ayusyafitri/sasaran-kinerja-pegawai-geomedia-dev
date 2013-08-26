function paging(n,content,curpage,showpage,pagenav,thislink,preflink,nextlink){
    
    //how much items per page to show
    var show_per_page = n; 
    //getting the amount of elements inside content div
    var number_of_items = $('.'+content).children().size();
    //calculate the number of pages we are going to have
    var number_of_pages = Math.ceil(number_of_items/show_per_page);
    
    //set the value of our hidden input fields
	if($('.'+curpage).val()==''){
		$('.'+curpage).val(0);
	}
    $('.'+showpage).val(show_per_page);
    
    //now when we got all we need for the navigation let's make it '
    
    /* 
    what are we going to have in the navigation?
        - link to previous page
        - links to specific pages
        - link to next page
    */
    var navigation_html = '<li class="'+preflink+'"><a  href="javascript:previous(\''+content+'\',\''+curpage+'\',\''+showpage+'\',\''+thislink+'\');">Prev</a></li>';
    var current_link = 0;
    while(number_of_pages > current_link){
        navigation_html += '<li class="'+thislink+'" longdesc="' + current_link +'"><a  href="javascript:go_to_page('+current_link +',\''+content+'\',\''+curpage+'\',\''+showpage+'\',\''+thislink+'\')">'+ (current_link + 1) +'</a></li>';
        current_link++;
    }
    navigation_html += '<li class="'+nextlink+'"><a  href="javascript:next(\''+content+'\',\''+curpage+'\',\''+showpage+'\',\''+thislink+'\');">Next</a></li>';
    
    $('.'+pagenav).html(navigation_html);
	
	//if(p>0){
	var page = $('.'+curpage).val();
	go_to_page(page,content,curpage,showpage,thislink);
	//}else{
	//	//add active_page class to the first page link
	//	$('.'+pagenav+' .'+thislink+':first').addClass('active');
	//	
	//	//hide all the elements inside content div
	//	$('.'+content).children().css('display', 'none');
	//	
	//	//and show the first n (show_per_page) elements
	//	$('.'+content).children().slice(0, show_per_page).css('display', 'table-row');
	//}
}
 
function previous(content,curpage,showpage,thislink){
    new_page = parseInt($('.'+curpage).val()) - 1;
    //if there is an item before the current active link run the function
    if($('.active').prev('.'+thislink).length==true){
        go_to_page(new_page,content,curpage,showpage,thislink);
    }
}
 
function next(content,curpage,showpage,thislink){
    new_page = parseInt($('.'+curpage).val()) + 1;
    //if there is an item after the current active link run the function
    if($('.active').next('.'+thislink).length==true){
        go_to_page(new_page,content,curpage,showpage,thislink);
    }
}
function go_to_page(page_num,content,curpage,showpage,thislink){
    //get the number of items shown per page
    var show_per_page = parseInt($('.'+showpage).val());
    
    //get the element number where to start the slice from
    start_from = page_num * show_per_page;
    
    //get the element number where to end the slice
    end_on = start_from + show_per_page;
    //hide all children elements of content div, get specific items and show them
	
    $('.'+content).children().css('display', 'none').slice(start_from, end_on).css('display', 'table-row');
    
    /*get the page link that has longdesc attribute of the current page and add active_page class to it
    and remove that class from previously active page link*/
    $('.'+thislink+'[longdesc=' + page_num +']').addClass('active').siblings('.active').removeClass('active');
    
    //update the current page input field
    $('.'+curpage).val(page_num);
}