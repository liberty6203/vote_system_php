function getParams(name) {
    var pos, str, para, parastr;
    var array = []
    str = window.location.href;
    if (str.split("?")[1] != undefined && str.split("=")[1] != undefined) {
      parastr = str.split("?")[1];
      parastr=decodeURIComponent(parastr);
      console.log(parastr);
      var arr = []
      arr = parastr.split("&");
      
      for (var i = 0; i < arr.length; i++) {
        array[arr[i].split("=")[0]] = arr[i].split("=")[1];
      }
 
    }
 
    console.log(array);
 
    //alert(array["projectId"]);
    return array[name];//project为所要获取的参数
}