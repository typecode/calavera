/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
88888888888                               d88P  .d8888b.                888          
    888                                  d88P  d88P  Y88b               888          
    888                                 d88P   888    888               888          
    888  888  888 88888b.   .d88b.     d88P    888         .d88b.   .d88888  .d88b.  
    888  888  888 888 "88b d8P  Y8b   d88P     888        d88""88b d88" 888 d8P  Y8b 
    888  888  888 888  888 88888888  d88P      888    888 888  888 888  888 88888888 
    888  Y88b 888 888 d88P Y8b.     d88P       Y88b  d88P Y88..88P Y88b 888 Y8b.     
    888   "Y88888 88888P"   "Y8888 d88P         "Y8888P"   "Y88P"   "Y88888  "Y8888  
              888 888                                                                
         Y8b d88P 888                                                                
          "Y88P"  888

::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

if (!CALAVERA) {
	var CALAVERA = {
		version: 0.1
	};
}

// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

(function(app, $) {
	
	var debug = true;
	
	if (debug && 
		typeof console !== "undefined" &&
		typeof console.debug !== "undefined") 
	{
		app.log = function(message, level) {
			console[level || "info"](message);
		};
		app.dump = function(obj) {
			console.log(obj);
		}
	} else {
		app.log = app.dump = function() {};
	}
	
	app.instances = {
		browser: {}
	};
	
	app.parser = {
		// convert "Npx" to N
		px: function(str) {
			return Number(str.substring(0, str.length - 2));
		}
	};
	
	app.menu = function(selector, options) {
		var $menu, o;
		
		app.log("app[menu]");
		
		o = $.extend({
			selectedClass: "selected",
			slideSpeed: 100
		}, options);
		
		$menu = $(selector);
		
		// setting an explicit width, to insure that 
		// expanding a section doesn't widen the menu
		$menu.width( $menu.width() );
		
		$menu.children("li").each(function() {
			var item = $(this);
			if (item.children("ul").length === 1) {
				item.children("a").click(function(e) {
					e.preventDefault();
					$menu.openSection(item);
				});
			}
		});
		
		$menu.openSection = function(item) {
			var submenu = item.children("ul");
			if (!submenu.length)
				return false;
			
			submenu.slideToggle(o.slideSpeed);
			item.toggleClass(o.selectedClass);
			
			item.siblings().each(function() {
				var sib = $(this);
				if (sib.hasClass(o.selectedClass)) {
					sib.children("ul").slideUp(o.slideSpeed);
					sib.removeClass(o.selectedClass);
				}
			});
		};
		
		return $menu;
	};
		
}(CALAVERA, jQuery));