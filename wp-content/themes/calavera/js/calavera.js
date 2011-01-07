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
		version: 0.1,
		name: "Calavera"
	};
}

// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

(function(app, $) {
	
	var debug = true;
	
	// for converting "Npx" to N
	function px(str) {
		return Number(str.substring(0, str.length - 2));
	};
	
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
	
	app.config = {};
	app.instances = {};
	
	app.menu = function(options) {
		var $menu, o;
		
		app.log("app[menu]");
		
		o = $.extend({
			selector:"#menu",
			selectedClass: "selected",
			slideSpeed: 100
		}, options);
		
		$menu = $(o.selector);
		
		// setting an explicit width, to insure that 
		// expanding a section doesn't widen the menu
		$menu.width( $menu.width() );
		
		$menu.children("li").each(function() {
			var section = $(this);
			if (section.children("ul").length === 1) {
				section.children("a").click(function(e) {
					e.preventDefault();
					$menu.toggleSection(section);
				});
			}
		});
		
		$menu.toggleSection = function(section) {
			var submenu;
			app.log("app[menu][toggleSection]");
			submenu = section.children("ul");
			if (!submenu.length)
				return false;
			
			submenu.slideToggle(o.slideSpeed);
			section.toggleClass(o.selectedClass);
			
			section.siblings().each(function() {
				var sib = $(this);
				if (sib.hasClass(o.selectedClass)) {
					sib.children("ul").slideUp(o.slideSpeed);
					sib.removeClass(o.selectedClass);
				}
			});
		};
		
		return $menu;
	};
	
	app.config.videoSettings = {
		controlsBelow: true,
		controlsAtStart: true,
		controlsHiding: false
	};
	
	app.videos = function() {
		var videos;
		app.log("app[videos]");
		videos = [];
		$("video").each(function(i) {
			var $v = $(this).VideoJS(app.config.videoSettings);
			$v.player = function() {
				return $v[0].player;
			};
			videos[i] = $v;
		});
		return videos;
	};
	
	app.scrollPane = function(options) {
		var $wrapper, o;
		
		app.log("app[scrollPane]");
		
		o = $.extend({
			selector:"#scroll-pane"
		}, options);
		
		$wrapper = $(o.selector);
		
		$wrapper.find(".scroll-controls").find(".prev").click(function(e) {
			e.preventDefault();
			$wrapper.goPrev();
		}).end().find(".next").click(function(e) {
			e.preventDefault();
			$wrapper.goNext();
		});
		
		$wrapper.goPrev = function() {
			app.log("app[scrollPane][goPrev]");
		};
		
		$wrapper.goNext = function() {
			app.log("app[scrollPane][goNext]");
		};
		
		return $wrapper;
	};
	
	app.infiniteScroll = function() {
		app.log("app[infiniteScroll]");
	};
	
}(CALAVERA, jQuery));

