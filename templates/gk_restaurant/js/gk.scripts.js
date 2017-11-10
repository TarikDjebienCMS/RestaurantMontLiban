window.addEvent('domready', function(){
	// smooth anchor scrolling
	new SmoothScroll(); 
	// style area
	if(document.id('gkStyleArea')){
		$$('#gkStyleArea a').each(function(element,index){
			element.addEvent('click',function(e){
	            e.stop();
				changeStyle(index+1);
			});
		});
	}
	// font-size switcher
	if(document.id('gkTools') && document.id('gkComponentWrap')) {
		var current_fs = 100;
		var content_fx = new Fx.Tween(document.id('gkComponentWrap'), { property: 'font-size', unit: '%', duration: 200 }).set(100);
		document.id('gkToolsInc').addEvent('click', function(e){ 
			e.stop(); 
			if(current_fs < 150) { 
				content_fx.start(current_fs + 10); 
				current_fs += 10; 
			} 
		});
		document.id('gkToolsReset').addEvent('click', function(e){ 
			e.stop(); 
			content_fx.start(100); 
			current_fs = 100; 
		});
		document.id('gkToolsDec').addEvent('click', function(e){ 
			e.stop(); 
			if(current_fs > 70) { 
				content_fx.start(current_fs - 10); 
				current_fs -= 10; 
			} 
		});
	}
	// login popup
	if(document.id('gkPopupLogin')) {
		var popup_overlay = document.id('gkPopupOverlay');
		popup_overlay.setStyles({'display': 'block', 'opacity': '0'});
		popup_overlay.fade('out');

		var opened_popup = null;
		var popup_login = null;
		var popup_login_h = null;
		var popup_login_fx = null;
		
		if(document.id('gkPopupLogin') && document.getElement('.gkmenu .login')) {
			popup_login = document.id('gkPopupLogin');
			popup_login.setStyle('display', 'block');
			popup_login_h = popup_login.getElement('.gkPopupWrap').getSize().y;
			popup_login_fx = new Fx.Morph(popup_login, {duration:200, transition: Fx.Transitions.Circ.easeInOut}).set({'opacity': 0, 'height': 0 }); 
			document.getElement('.gkmenu .login').addEvent('click', function(e) {
				new Event(e).stop();
				popup_overlay.fade(0.45);
				popup_login_fx.start({'opacity':1, 'height': popup_login_h});
				opened_popup = 'login';
				
				(function() {
					if(document.id('modlgn-username')) {
						document.id('modlgn-username').focus();
					}
				}).delay(600);
			});
		}
		
		popup_overlay.addEvent('click', function() {
			if(opened_popup == 'login')	{
				popup_overlay.fade('out');
				popup_login_fx.start({
					'opacity' : 0,
					'height' : 0
				});
			}
		});
	}
	// K2 font-size switcher fix
	if(document.id('fontIncrease') && document.getElement('.itemIntroText')) {
		document.id('fontIncrease').addEvent('click', function() {
			document.getElement('.itemIntroText').set('class', 'itemIntroText largerFontSize');
		});
		
		document.id('fontDecrease').addEvent('click', function() {
			document.getElement('.itemIntroText').set('class', 'itemIntroText smallerFontSize');
		});
	}
});

window.addEvent('load', function() {
	// gkHeader typography elements
	document.getElements('.gkHeader').each(function(header) {
		var elements = header.getChildren();
		var animationStack = [];
		//
		elements.each(function(element) {
			//
			var delay = element.get('data-delay') || 500;
			var start = JSON.decode(element.get('data-start'));
			var end = JSON.decode(element.get('data-end'));
			var time = element.get('data-time') || 500;
			//
			element.setStyles(start);
			//
			animationStack.push([element, end, time, delay]);
		});
		
		header.addClass('loaded');
		//
		animationStack.each(function(animation){
			gkRunHeaderAnimation(animation);
		});
	});
});

function gkRunHeaderAnimation(animation) {
	(function() {
		new Fx.Morph(animation[0], { duration: animation[2] }).start(animation[1]);
	}).delay(animation[3]);
}

// function to set cookie
function setCookie(c_name, value, expire) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expire);
	document.cookie=c_name+ "=" +escape(value) + ((expire==null) ? "" : ";expires=" + exdate.toUTCString());
}
// Function to change styles
function changeStyle(style){
	var file1 = $GK_TMPL_URL+'/css/style'+style+'.css';
	var file2 = $GK_TMPL_URL+'/css/typography/typography.style'+style+'.css';
	var file3 = $GK_TMPL_URL+'/css/typography/typography.iconset.style'+style+'.css';
	new Asset.css(file1);
	new Asset.css(file2);
	new Asset.css(file3);
	Cookie.write('gk_restaurant_j25_style', style, { duration:365, path: '/' });
}