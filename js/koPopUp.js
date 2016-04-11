/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function koPopUp(id, close) {
    
    if((close === '' )|| (close === undefined)){
        close = 'yes';
    }
   // alert(close);
    //find out if its a class or an id
    var imAClass = jQuery('.'+id).length;
    var imAnID = jQuery('#'+id).length;
    var thisElement;
    if(imAClass >=1){
        thisElement = "."+id;
    }
    if(imAnID >=1){
        thisElement = "#"+id;
    }
    //Dont show on the phone if told not to
    var phone = jQuery(thisElement).attr("data-phone");
    var myWindow = jQuery(window).width();
    var display = "show";
    if(((phone == "no") || (phone == undefined)) && (myWindow <= "480")){
       // jQuery(thisElement).remove();
       // display = "hide";
    }
   
    if(display == "show"){
        var indexHigh = 0;
        jQuery('div').each(function(){
            var curIndex = parseInt(jQuery(this).css('z-index'), 10); 
            if(curIndex > indexHigh){
                indexHigh = curIndex;
            }
        });
         
        //the above code makes sure the pop up has the highest z-index
        
    
        /*
                   * This is the meat, creates a 'grey out' div, moves the div to the same 
                   * element as the pop up div, centers the popup div, shows it all, and if you click, removes it 
                   * all and sets the seen this var
                   */
               jQuery('#aboveAll').css("z-index", indexHigh+4);   
        jQuery(thisElement).css("position","fixed");
        jQuery(thisElement).css("top", Math.max(0, ((jQuery(window).height() - jQuery(thisElement).outerHeight()) / 2)));
        jQuery(thisElement).css("left", Math.max(0, ((jQuery(window).width() - jQuery(thisElement).outerWidth()) / 2)));
        jQuery(thisElement).css("z-index", indexHigh+2);
        jQuery(thisElement).css('overflow','hidden');
        jQuery(thisElement+" iframe").css({
            "box-shadow":"5px 5px 10px #000000", 
            "border":"0px"
        })
        jQuery(thisElement).addClass(id+'_clickRemove');
        if(close === 'yes'){
            jQuery('body').append('<span id="'+id+'_closeX" style="float:right; color:#fff; font-size:35px; cursor:pointer;">&times;</span>');  // A little x that tells people how to close the ad 
        jQuery('#'+id+'_closeX').appendTo('.'+id+'_clickRemove');
        }
        jQuery('body').append('<div id="'+id+'_greyOut" style=""></div>');
        
        jQuery('#'+id+'_greyOut').insertAfter('.'+id+'_clickRemove');
        jQuery('#'+id+'_greyOut').css({
            "background-color":"#000", 
            "opacity":"0.5", 
            "width":"100%", 
            "height":"100%", 
            "position":"fixed",
            "top":"0", 
            "bottom":"0", 
            "left":"0", 
            "right":"0", 
            "z-index":indexHigh++
        });
        jQuery(window).resize(function(){ //Lets readjust position if the screen changes size on us, probably not needed, but fun.. 
            jQuery(thisElement).css("top", Math.max(0, ((jQuery(window).height() - jQuery(thisElement).outerHeight()) / 2)));
            jQuery(thisElement).css("left", Math.max(0, ((jQuery(window).width() - jQuery(thisElement).outerWidth()) / 2)));
        });  
            
        jQuery(thisElement).show();
        if(close === 'yes'){
        jQuery('#'+id+'_greyOut, #'+id+'_closeX').click(function(){
            jQuery('.'+id+'_clickRemove').hide();
            jQuery('#'+id+'_greyOut').remove();
       
            
        });        
         }
    } 
}