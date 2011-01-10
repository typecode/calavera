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
	
	function getSelectorFromHash(url) {
		var buf = url.split("#");
		if (buf.length > 1) { return "#" + buf[buf.length - 1]; }
		return false;
	};
	
	function selectFromURL(url) {
		var selector, element;
		selector = getSelectorFromHash(url);
		element = $(selector);
		return element.length ? element : false;
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
		};
	} else {
		app.log = app.dump = function() {};
	}
	
	app.config = {
		selectedClass: "selected"
	};
	app.instances = {};
	app.events = $({});
	
	app.menu = function(options) {
		var $menu, 
			pageLocalItems,
			panelSelectedHandler,
			o;
		
		app.log("app[menu]");
		
		o = $.extend({
			selector:"#menu",
			slideSpeed: 100
		}, options);
		
		$menu = $(o.selector).eq(0);
		// array containing jQuery objects of the menu items 
		// that "link" to elements on the current page:
		pageLocalItems = [];
		
		panelSelectedHandler = function(e, d) {
			app.log("app[events][navigation.panelSelected]");
			if (d && d.id) {				
				$.each(pageLocalItems, function(i) {
					var item, targetID, section;
					item = pageLocalItems[i];
					targetID = item.data("targetID");
					if (targetID) {
						if (targetID === d.id) {
							item.addClass(app.config.selectedClass);
							section = item.data("section");
							if (section && !section.hasClass(app.config.selectedClass)) {
								$menu.toggleSection(section);
							}
						} else {
							item.removeClass(app.config.selectedClass);
						}
					}
				});
			}
		};
		
		// setting an explicit width, to insure that 
		// expanding a section doesn't widen the menu:
		$menu.width( $menu.width() );
		
		$menu.children("li").each(function() {
			var section = $(this), submenu;
			section = $(this);
			submenu = section.children("ul");
			if (submenu.length === 1) {
				section.children("a").click(function(e) {
					e.preventDefault();
					$menu.toggleSection(section);
				});
				submenu.children("li").each(function() {
					$(this).children("a").each(function() {
						var link, target, targetID;
						link = $(this);
						target = selectFromURL( link.attr("href") );
						if (target) {
							targetID = target.attr("id");
							link.data("targetID", targetID);
							link.data("section", section);
							pageLocalItems.push(link);
							link.click(function(e) {
								e.preventDefault();
								app.events.trigger("navigation.selectPanel", {
									id: targetID
								});
							});
						}
					});
				});
			}
		});
		
		app.events.bind("navigation.panelSelected", panelSelectedHandler);
		
		$menu.toggleSection = function(section) {
			var submenu;
			app.log("app[menu][toggleSection]");
			submenu = section.children("ul");
			if (!submenu.length === 1) { return false; }
			
			submenu.slideToggle(o.slideSpeed);
			section.toggleClass(app.config.selectedClass);
			
			section.siblings().each(function() {
				var sib = $(this);
				if (sib.hasClass(app.config.selectedClass)) {
					sib.children("ul").slideUp(o.slideSpeed);
					sib.removeClass(app.config.selectedClass);
				}
			});
		};
		
		return $menu;
	};
	
	app.scrollPane = function(options) {
		var $sp,
			scroll,
			panels,
			panelHeight,
			currentIndex,
			goToIndex,
			selectPanelHandler,
			o;
		
		app.log("app[scrollPane]");
		
		o = $.extend({
			selector:"#scroll-pane",
			scrollSpeed: 200,
			startIndex: 0
		}, options);
		
		$sp = $(o.selector).eq(0);
		scroll = $sp.children(".holder").eq(0);
		panels = scroll.children();
		panelHeight = $sp.height();
		currentIndex = o.startIndex;
		
		goToIndex = function(index) {
			if (index < 0) { index = panels.length - 1; }
			else if (index > panels.length - 1) { index = 0; }
			scroll.animate(
				{ marginTop: -1*panelHeight*index }, 
				o.scrollSpeed, 
				function() {
					currentIndex = index;
					panels.each(function(i) {
						var panel, panelID;
						panel = panels.eq(i);
						if (i === currentIndex) {
							panel.addClass(app.config.selectedClass);
							panelID = panel.attr("id");
							location.hash = panelID;
							app.events.trigger("navigation.panelSelected", {
								id: panelID
							});
						} else {
							panel.removeClass(app.config.selectedClass);
						}
					});
				}
			);
		};
		
		selectPanelHandler = function(e, d) {
			app.log("app[events][navigation.selectPanel]");
			if (d && d.id) { $sp.goToID(d.id); }
		};
		
		panels.each(function() {
			var page = $(this);
			page.height(panelHeight);
			page.css("overflow", "hidden");
		});
		
		app.events.bind("navigation.selectPanel", selectPanelHandler);
		
		$sp.find(".scroll-controls").find(".prev").click(function(e) {
			e.preventDefault();
			$sp.goPrev();
		}).end().find(".next").click(function(e) {
			e.preventDefault();
			$sp.goNext();
		});
		
		$sp.goToFirst = function() {
			goToIndex(o.startIndex);
		};
		
		$sp.goPrev = function() {
			app.log("app[scrollPane][goPrev]");
			goToIndex( currentIndex - 1 );
			return $sp;
		};
		
		$sp.goNext = function() {
			app.log("app[scrollPane][goNext]");	
			goToIndex( currentIndex + 1 );
			return $sp;
		};
		
		$sp.goToID = function(id) {
			app.log("app[scrollPane][selectAndGo]");
			panels.each(function(i) {
				if ($(this).attr("id") === id) { goToIndex(i); }
			});
			return $sp;
		};
				
		return $sp;
	};
		
	app.infiniteScroll = function() {
		app.log("app[infiniteScroll]");
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
			
			app.events.bind("navigation.panelSelected", function(e, d) {
				$v[0].player.pause();
			});
			
			videos[i] = $v;
		});
		return videos;
	};
	
	$(function() {
		app.log("document[ready]");
		
		app.instances.menu = app.menu();
		
		if (typeof ENVIRONMENT === "object") {
			if (typeof ENVIRONMENT.features === "object") {
				$.each(ENVIRONMENT.features, function(i) {
					if ($.isFunction(app[ENVIRONMENT.features[i].feature])) {
						app.instances[ENVIRONMENT.features[i].feature] = 
							app[ENVIRONMENT.features[i].feature](ENVIRONMENT.features[i].options || null);
					}
				});
			}
		}
		
		if (location.hash) {
			app.events.trigger("navigation.selectPanel", {
				id: location.hash.substring(1)
			});
		} else if (app.instances.scrollPane) {
			app.instances.scrollPane.goToFirst();
		}
	});
	
}(CALAVERA, jQuery));

