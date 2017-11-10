window.addEvent('load', function() {
	if(document.id('gkExtraMenu')) {
		// fix for the iOS devices		
		document.getElements('#gkExtraMenu ul li span').each(function(el) {
			el.setProperty('onmouseover', '');
		});
		
		document.getElements('#gkExtraMenu ul li a').each(function(el) {
			el.setProperty('onmouseover', '');
			
			if(el.getParent().hasClass('haschild') && document.getElement('body').getProperty('data-tablet') != null) {
				el.addEvent('click', function(e) {
					if(el.retrieve("dblclick", 0) === 0) {
						e.stop();
						el.store("dblclick", new Date().getTime());
					} else {
						var now = new Date().getTime();
						if(now - el.retrieve("dblclick", 0) < 500) {
							window.location = el.getProperty('href');
						} else {
							e.stop();
							el.store("dblclick", new Date().getTime());
						}
					}
				});
			}
		});
		
		var base = document.id('gkExtraMenu');
		
		if($GKMenu && ($GKMenu.height || $GKMenu.width)) {		
			base.getElements('li.haschild').each(function(el){		
				if(el.getElement('.childcontent')) {
					var content = el.getElement('.childcontent');
					var prevh = content.getSize().y;
					var prevw = content.getSize().x;
					
					var fxStart = { 'height' : $GKMenu.height ? 0 : prevh, 'width' : $GKMenu.width ? 0 : prevw, 'opacity' : 0 };
					var fxEnd = { 'height' : prevh, 'width' : prevw, 'opacity' : 1 };
					
					var fx = new Fx.Morph(content, {
						duration: $GKMenu.duration, 
						link: 'cancel', 
						onComplete: function() { 
							if(content.getSize().y == 0){ 
								content.setStyle('overflow', 'hidden'); 
							} else if(content.getSize().y - prevh < 30 && content.getSize().y - prevh >= 0) {
								//console.log('GetSize: ' + content.getSize().y + '  prevh: ' + prevh);
								content.setStyle('overflow', 'visible');
							}
						}
					});
					
					fx.set(fxStart);
					content.setStyles({'left' : 'auto', 'overflow' : 'hidden' });
					
					el.addEvents({
						'mouseenter': function(){ 
							fx.start(fxEnd);
						},
					
						'mouseleave': function(){
							content.setStyle('overflow', 'hidden');
							fx.start(fxStart);
						}
					});
				}
			});
		}
	}
}); 