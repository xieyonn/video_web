$(document).ready(function(){
    var menu_control_btn = $("#menu_control_btn");
    var left_menu = $("#left_menu");
    var data_page = $("#data_page");
    var open_menu = false;
    
    menu_control_btn.click(function(){
       if(! open_menu){
           left_menu.hide();
           data_page.removeClass('col-lg-10').addClass('col-lg-12');
           open_menu = true;
       }else{
           left_menu.show();
           data_page.removeClass('col-lg-12').addClass('col-lg-10');
           open_menu = false;
       }
    });
}); 