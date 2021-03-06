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

	by Lev Kanter
	   lev@typeslashcode.com
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

window.CALAVERA = {
	version: 0.1,
	name: "Calavera"
};

// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

(function(app, environment, $) {
	
	var config = {
		debug: true,
		
		selectedClass: "selected",
		
		videoSettings: {
			controlsBelow: true,
			controlsAtStart: true,
			controlsHiding: false
		}
	};
	
	if (config.debug && 
			typeof window.console !== "undefined" &&
			typeof window.console.debug !== "undefined") {
		app.log = function(message, level) {
			window.console[level || "info"](message);
		};
		app.dump = function(obj) {
			window.console.log(obj);
		};
	} else {
		app.log = app.dump = function() {};
	}
	
	/**
	 * initialize environment-specific components
	 * from an array of "feature" objects, each one
	 * of the form { feature: "foo", options: {} },
	 * which invokes app[foo](options)
	 */
	function initAppFeatures() {
		var makeFeature = function(o) {
			if (app.instances[o.feature]) {
				app.log(o.feature + " already initialized", "warn");
			} else if (typeof app[o.feature] === "function") {
				app.instances[o.feature] = app[o.feature](o.options);
			}
		};

		if ($.isArray(environment.features)) {
			$.each(environment.features, function(i) { 
				makeFeature(environment.features[i]);
			});
		}
	}
	
	function getSelectorFromHash(url) {
		var buf = url.split("#");
		if (buf.length > 1) { return "#" + buf[buf.length - 1]; }
		return false;
	}
	
	/**
	 * If a URL links to a DOM element on the page, 
	 * Find that element and return it as a jQuery obj
	 * otherwise, return false
	 */
	function selectFromURL(url) {
		var selector, element;
		selector = getSelectorFromHash(url);
		if (!selector) { return false; }
		element = $(selector);
		return element.length ? element : false;
	}
	
	app.instances = {};
	app.events = $({});
		
	app.menu = function(options) {
		var $menu, 
			pageLocalItems, // array containing jQuery objects of the menu items
			                // that "link" to elements on the current page
			panelSelectedHandler,
			o;
		
		app.log("app[menu]");
		
		o = $.extend({
			selector:"#menu",
			slideSpeed: 100
		}, options);
		
		$menu = $(o.selector).eq(0);
		pageLocalItems = [];
		
		panelSelectedHandler = function(e, d) {
			app.log("app[menu][panelSelectedHandler]");
			if (d && d.id) {				
				$.each(pageLocalItems, function(i) {
					var item, targetID, section;
					item = pageLocalItems[i];
					targetID = item.data("targetID");
					if (targetID) {
						if (targetID === d.id) {
							item.addClass(config.selectedClass);
							section = item.data("section");
							if (section && !section.hasClass(config.selectedClass)) {
								$menu.toggleSection(section);
							}
						} else {
							item.removeClass(config.selectedClass);
						}
					}
				});
			}
		};
		
		// setting an explicit width to insure that 
		// expanding a section doesn't widen the menu:
		$menu.width( $menu.width() );
		
		$menu.children("li").each(function() {
			var section, submenu;
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
			} else {
				section.children("a").attr("title", "");
			}
		});
		
		app.events.bind("navigation.panelSelected", panelSelectedHandler);
		
		$menu.toggleSection = function(section) {
			var submenu;
			app.log("app[menu][toggleSection]");
			submenu = section.children("ul");
			if (submenu.length !== 1) { return false; }
			
			submenu.slideToggle(o.slideSpeed);
			section.toggleClass(config.selectedClass);
			
			section.siblings().each(function() {
				var sib = $(this);
				if (sib.hasClass(config.selectedClass)) {
					sib.children("ul").slideUp(o.slideSpeed);
					sib.removeClass(config.selectedClass);
				}
			});
		};
		
		return $menu;
	};
	
	app.scrollPane = function(options) {
		var $sp,
			scroll, // the parent element that holds all the panels
			panels, // array of individual items 
			panelHeight,
			currentIndex,
			goToIndex,
			selectPanelHandler,
			o;
		
		app.log("app[scrollPane]");
		
		o = $.extend({
			selector: "#scroll-pane",
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
							panel.addClass(config.selectedClass);
							panelID = panel.attr("id");
							window.location.hash = panelID;
							app.events.trigger("navigation.panelSelected", {
								id: panelID
							});
						} else {
							panel.removeClass(config.selectedClass);
						}
					});
				}
			);
		};
		
		selectPanelHandler = function(e, d) {
			app.log("app[scrollPane][selectPanelHandler]");
			if (d && d.id) { $sp.goToID(d.id); }
		};
			
		app.events.bind("navigation.selectPanel", selectPanelHandler);
		
		$sp.find(".scroll-controls").find(".prev").click(function(e) {
			e.preventDefault();
			$sp.goPrev();
		}).end().find(".next").click(function(e) {
			e.preventDefault();
			$sp.goNext();
		});
		
		$sp.goToFirst = function() {
			app.log("app[scrollPane][goToFirst]");
			goToIndex(o.startIndex);
			return $sp;
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
			app.log("app[scrollPane][goToID]");
			panels.each(function(i) {
				if ($(this).attr("id") === id) { 
					goToIndex(i);
					return $sp;
				}
			});
			return $sp;
		};
				
		return $sp;
	};
	
	app.videos = function() {
		var videos;
		app.log("app[videos]");
		videos = [];
		$("video").each(function(i) {
			var $v = $(this).VideoJS(config.videoSettings);
			
			app.events.bind("navigation.panelSelected", function(e, d) {
				app.log("app[videos][" + i + "][panelSelectedHandler]");
				$v[0].player.pause();
			});
			
			videos[i] = $v;
		});
		return videos;
	};
	
	app.infiniteScroll = function(options) {
		var $is, o;
		
		app.log("app[infiniteScroll]");
		
		o = $.extend({
			selector: ".main",
			navSelector: ".pagination",
			nextSelector: ".pagination .next a",
			itemSelector: ".post",
			loadingImg: null
		}, options);
		
		$is = $(o.selector).infinitescroll({
			navSelector: o.navSelector,
			nextSelector: o.nextSelector,
			itemSelector: o.itemSelector,
			loadingImg: o.loadingImg,
			animate: true,
			loadingText: "",
			donetext: "",
			debug: config.debug
		});
		
		$(window.document).bind('retrieve.infscr', function() {
			app.log("document[retrieve.infscr]");
		});
		
		return $is;
	};
	
	app.blogPosts = function(options) {
		var posts, // array of blog posts
			blogPost, // initializer for an individual blog post
			o;
			
		app.log("app[blogPosts]");
		
		o = $.extend({
			selector: ".post",
			moreLinkSelector: "a.more-link",
			moreText:"Read more",
			lessText:"Read less",
			tailSelector: ".part-2",
			slideSpeed: 100
		}, options);
		
		posts = [];
		
		blogPost = function($bp, index) {
			var moreLink, 
				part2, 
				isExpanded;
				
			moreLink = $bp.find(o.moreLinkSelector);
			part2 = $bp.find(o.tailSelector);
			isExpanded = false;
			
			$bp.toggleBlogPost = function() {
				app.log("app[blogPosts][" + index + "][toggleBlogPost]");
				if (isExpanded) {
					part2.slideUp(o.slideSpeed, function() {
						isExpanded = false;
						moreLink.text(o.moreText);
					});
				} else { 
					part2.slideDown(o.slideSpeed, function() {
						isExpanded = true;
						moreLink.text(o.lessText);
					});
				}
			};
			
			if (moreLink.length === 1) {
				if (part2.length === 1) {
					moreLink.click(function(e) {
						e.preventDefault();
						$bp.toggleBlogPost();
					});
				}
			}
			
			return $bp;
		};
		
		$(o.selector).each(function(i) {
			posts[i] = blogPost($(this), i);
		});
		
		return posts;
	};
	
// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
	
	/**
	 * Kick-off
	 */
	$(function() {
		app.log("document[ready]");
		
		app.instances.menu = app.menu();
		
		if (typeof environment === "object") {
			initAppFeatures();
		}
		
		app.dump(app.instances);
		
		// if a specific panel was linked to, select it 
		// otherwise, select the first panel:
		if (app.instances.scrollPane) {
			if (window.location.hash) {
				app.events.trigger("navigation.selectPanel", {
					id: window.location.hash.substring(1)
				});
			} else {
				app.instances.scrollPane.goToFirst();
			}
		}
	});
	
	app.log("::::::::::::::::::::::::::::::::::::::::::::::::");
	app.log(app.name + " " + app.version);
	app.log("::::::::::::::::::::::::::::::::::::::::::::::::");
	
}(window.CALAVERA, window.ENVIRONMENT, window.jQuery));