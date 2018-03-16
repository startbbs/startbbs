(function() { //加载
  varobj =  {};
  /**
   * 动态加载脚本函数
   * @param url 要加载的脚本路径
   * @param callback  回调函数
   */
  obj.loadScript =function(url,callback){
    var doc = document;
    var script = doc.createElement("script");
    script.type = "text/javascript";
    if(script.readyState){ //IE
      script.onreadystatechange = function(){
        if(script.readyState=="load"||script.readyState=="complete"){
         script.onreadystatechange = null;
         callback();
        }
      };
    }else{
      script.onload = function(){
        callback();
      };
    }
    script.src = url;
    doc.getElementsByTagName("head")[0].appendChild(script);
  };
 varjsList = [
   "module.js",
   "hotkeys.js",
   "uploader.js",
   "simditor.js"
 ];
  function callback(){
      jsList.length?obj.loadScript(jsList.shift(),callback)
        :(function(){time =null})();
  }
  var time = setTimeout(function(){obj.loadScript(jsList.shift(),callback)},25);
})();