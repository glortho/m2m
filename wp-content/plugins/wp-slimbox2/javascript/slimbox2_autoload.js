jQuery(document).ready(function(b){if(slimbox2_options.mobile||!/android|iphone|ipod|series60|symbian|windows ce|blackberry/i.test(navigator.userAgent)){slimbox_CSS();closeKeys=slimbox2_options.closeKeys.split(",");previousKeys=slimbox2_options.previousKeys.split(",");nextKeys=slimbox2_options.nextKeys.split(",");for(var a in closeKeys){closeKeys[a]=parseInt(closeKeys[a])}for(var a in previousKeys){previousKeys[a]=parseInt(previousKeys[a])}for(var a in nextKeys){nextKeys[a]=parseInt(nextKeys[a])}load_slimbox()}});function slimbox_CSS(){jQuery(function(a){a("#lbOverlay").css("background-color",slimbox2_options.overlayColor);a("#lbPrevLink").hover(function(){a(this).css("background-image","url("+slimbox2_options.prev+")")},function(){a(this).css("background-image","")});a("#lbNextLink").hover(function(){a(this).css("background-image","url("+slimbox2_options.next+")")},function(){a(this).css("background-image","")});a("#lbCloseLink").css("background-image","url("+slimbox2_options.close+")")})}function load_slimbox(){jQuery(function($){var options={loop:slimbox2_options.loop,overlayOpacity:slimbox2_options.overlayOpacity,overlayFadeDuration:parseInt(slimbox2_options.overlayFadeDuration),resizeDuration:parseInt(slimbox2_options.resizeDuration),resizeEasing:slimbox2_options.resizeEasing,initialWidth:parseInt(slimbox2_options.initialWidth),initialHeight:parseInt(slimbox2_options.initialHeight),imageFadeDuration:parseInt(slimbox2_options.imageFadeDuration),captionAnimationDuration:parseInt(slimbox2_options.captionAnimationDuration),counterText:slimbox2_options.counterText,closeKeys:closeKeys,previousKeys:previousKeys,nextKeys:nextKeys};if(slimbox2_options.autoload){$("a[href]").filter(function(){return/\.(jpeg|bmp|jpg|png|gif)(\?[\d\w=&]*)?$/i.test(this.href)}).unbind("click").slimbox(options,function(el){return[encodeURI(el.href),(slimbox2_options.url)?'<a href="'+encodeURI(el.href)+'">'+eval(slimbox2_options.caption)+"</a>":eval(slimbox2_options.caption)]},function(el){return(this==el)||($(this).closest(slimbox2_options.selector)[0]&&($(this).closest(slimbox2_options.selector)[0]==$(el).closest(slimbox2_options.selector)[0]))})}else{$("a[rel^='lightbox']").unbind("click").slimbox(options,function(el){return[encodeURI(el.href),(slimbox2_options.url)?'<a href="'+encodeURI(el.href)+'">'+eval(slimbox2_options.caption)+"</a>":eval(slimbox2_options.caption)]},function(el){return(this==el)||((this.rel.length>8)&&(this.rel==el.rel))})}if(slimbox2_options.picasaweb){$("a[href^='http://picasaweb.google.'] > img:first-child[src]").parent().unbind("click").slimbox(options,function(el){return[el.firstChild.src.replace(/\/s\d+(?:\-c)?\/([^\/]+)$/,"/s640/$2"),(el.title||el.firstChild.alt)+'<br /><a href="'+encodeURI(el.href)+'">Picasa Web Albums page</a>']})}if(slimbox2_options.flickr){$("a[href^='http://www.flickr.com/photos/'] > img:first-child[src]").parent().unbind("click").slimbox(options,function(el){return[el.firstChild.src.replace(/_[mts]\.(\w+)$/,".$1"),(el.title||el.firstChild.alt)+'<br /><a href="'+encodeURI(el.href)+'">Flickr page</a>']})}})};