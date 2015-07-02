/*
* Notify Bar - jQuery plugin
*
* Copyright (c) 2009-2010 Dmitri Smirnov
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/mit-license.php
*
* Version: 1.2.2
*
* Project home:
* http://www.dmitri.me/blog/notify-bar
*/
 
/**
* param Object
*/
jQuery.notifyBar = function(settings) {
  
  (function($) {
    
    var bar = notifyBarNS = {};
    notifyBarNS.shown = false;
     
    if( !settings) {
    settings = {};
    }
    // HTML inside bar
    notifyBarNS.html = settings.html || "Your message here";
     
    //How long bar will be delayed, doesn't count animation time.
    notifyBarNS.delay = settings.delay || 1300;
     
    //How long notifyBarNS bar will be slided up and down
    notifyBarNS.animationSpeed = settings.animationSpeed || 130;
     
    //Use own jquery object usually DIV, or use default
    notifyBarNS.jqObject = settings.jqObject;
     
    //Set up own class
    notifyBarNS.cls = settings.cls || "";
    
    //close button
    notifyBarNS.close = settings.close || false;
    
    if( notifyBarNS.jqObject) {
      bar = notifyBarNS.jqObject;
      notifyBarNS.html = bar.html();
    } else {
      bar = jQuery("<div></div>")
      .addClass("jquery-notify-bar")
      .addClass(notifyBarNS.cls)
      .attr("id", "__notifyBar");
    }
         
    bar.html(notifyBarNS.html).hide();
    var id = bar.attr("id");
    switch (notifyBarNS.animationSpeed) {
      case "slow":
      asTime = 600;
      break;
      case "normal":
      asTime = 400;
      break;
      case "fast":
      asTime = 200;
      break;
      default:
      asTime = notifyBarNS.animationSpeed;
    }
    if( bar != 'object'); {
      jQuery("body").prepend(bar);
    }
    
    // Style close button in CSS file
    if( notifyBarNS.close) {
      bar.append(jQuery("<a href='#' class='notify-bar-close'>Close [X]</a>"));
      jQuery(".notify-bar-close").click(function() {
        if( bar.attr("id") == "__notifyBar") {
          jQuery("#" + id).slideUp(asTime, function() { jQuery("#" + id).remove() });
        } else {
          jQuery("#" + id).slideUp(asTime);
        }
        return false;
      });
    }
    
    bar.slideDown(asTime);
     
    // If taken from DOM dot not remove just hide
    if( bar.attr("id") == "__notifyBar") {
      setTimeout("jQuery('#" + id + "').slideUp(" + asTime +", function() {jQuery('#" + id + "').remove()});", notifyBarNS.delay + asTime);
    } else {
      setTimeout("jQuery('#" + id + "').slideUp(" + asTime +", function() {jQuery('#" + id + "')});", notifyBarNS.delay + asTime);
    }

})(jQuery) };

//textarea光标位置插入
(function($){ 
    $.fn.extend({ 
        insertAtCaret: function(myValue){ 
            var $t=$(this)[0]; 
            if (document.selection) { 
                this.focus(); 
                sel = document.selection.createRange(); 
                sel.text = myValue; 
                this.focus(); 
            } 
            else 
                if ($t.selectionStart || $t.selectionStart == '0') { 
                    var startPos = $t.selectionStart; 
                    var endPos = $t.selectionEnd; 
                    var scrollTop = $t.scrollTop; 
                    $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length); 
                    this.focus(); 
                    $t.selectionStart = startPos + myValue.length; 
                    $t.selectionEnd = startPos + myValue.length; 
                    $t.scrollTop = scrollTop; 
                } 
                else { 
                    this.value += myValue; 
                    this.focus(); 
                } 
        } 
    }) 
})(jQuery); 

/*
 * 元素滚动固定
 */
(function($){ 
    $.fn.extend({ 
        autoFloat: function(top_position){ 
            if($(this).length == 0) {

                return;
            }
            var element = $(this);
            var top = element.position().top, pos = element.css("position");
            $(window).scroll(function() {
                var scrolls = $(this).scrollTop();
                if (scrolls > top) {
                    if (window.XMLHttpRequest) {
                        element.css({
                            position: "fixed",
                            top: top_position
                        });
                    } else {
                        element.css({
                            top: scrolls
                        });
                    }
                }else {
                    element.css({
                        position: "absolute",
                        top: top
                    });
                }
            });
        } 
    }) 
})(jQuery); 

