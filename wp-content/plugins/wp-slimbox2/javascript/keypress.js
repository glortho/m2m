var store="";jQuery(function(a){a(".keys").keyup(function(d){if(!a("#wp_slimbox_manual_key").is(":checked")){var c=(window.event)?event.keyCode:d.keyCode;var b=new Array();a(".keys").each(function(){b=b.concat((this.value).split(" ").join("").split(","))});if(a.inArray(c+"",b)!=-1){this.value=store.replace(/.$/,"");alert(a("#wp_slimbox_key_defined").val())}else{this.value=store+c}return false}}).keydown(function(b){if(!a("#wp_slimbox_manual_key").is(":checked")){store=(this.value==""?"":this.value+",");return false}})});