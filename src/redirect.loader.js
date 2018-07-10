    (function(){
      function emitScriptTag( filePath ){
        document.write('<scr'+'ipt type="text/javascript" src="'+filePath+'"></scr'+'ipt>');
      }
emitScriptTag('src/redirectShared.js');
emitScriptTag('src/redirect.js');
emitScriptTag('src/redirect_preboot.js');
    }());
