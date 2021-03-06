<?php

// No direct access.
defined('_JEXEC') or die;

$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');

?>

<?php if($this->API->get('fb_login', '0') == 1 || $this->API->get('fb_like', '0') == 1) : ?>
<gavern:social>
<div id="fb-root"></div>
<script type="text/javascript">
//<![CDATA[
   	window.fbAsyncInit = function() {
		FB.init({ appId: '<?php echo $this->API->get('fb_api_id', ''); ?>', 
			status: true, 
			cookie: true,
			xfbml: true,
			oauth: true
		});
   		    
	  	<?php if($this->API->get('fb_login', '0') == 1) : ?>
	  	function updateButton(response) {
	    	var button = document.getElementById('fb-auth');
		
			if(button) {	
	    		if (response.authResponse) {
	      		// user is already logged in and connected
				button.onclick = function() {
					if($('login-form')){
						$('modlgn-username').set('value','Facebook');
						$('modlgn-passwd').set('value','Facebook');
						$('login-form').submit();
					} else if($('com-login-form')) {
					   $('username').set('value','Facebook');
					   $('password').set('value','Facebook');
					   $('com-login-form').submit();
					}
				}
			} else {
	      		//user is not connected to your app or logged out
	      		button.onclick = function() {
					FB.login(function(response) {
					   if (response.authResponse) {
					      if($('login-form')){
					      	$('modlgn-username').set('value','Facebook');
					      	$('modlgn-passwd').set('value','Facebook');
					      	$('login-form').submit();
					      } else if($('com-login-form')) {
					         $('username').set('value','Facebook');
					         $('password').set('value','Facebook');
					         $('com-login-form').submit();
					      }
					  } else {
					    //user cancelled login or did not grant authorization
					  }
					}, {scope:'email'});  	
	      		}
	    	}
	    }
	  }
	  // run once with current status and whenever the status changes
	  FB.getLoginStatus(updateButton);
	  FB.Event.subscribe('auth.statusChange', updateButton);	
	  <?php endif; ?>
	};
    //      
    window.addEvent('load', function(){
    	(function(){
    		var e = document.createElement('script');
    		e.src = document.location.protocol + '//connect.facebook.net/<?php echo $this->API->get('fb_lang', 'en_US'); ?>/all.js';
            e.async = true;
    		document.getElementById('fb-root').appendChild(e);
    	}()); 
    }); 
    //]]>
</script>
</gavern:social>
<?php endif; ?>

<?php if($this->API->get('google_plus', '1') == 1 && $option == 'com_content' && $view == 'article') : ?>
<gavern:social>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: '<?php echo $this->API->get("google_plus_lang", "en-GB"); ?>'}
</script>
</gavern:social>
<?php endif; ?>

<!-- Pinterest script --> 
<?php if($this->API->get('pinterest_btn', '1') == 1 && $option == 'com_content' && $view == 'article') : ?><gavern:social>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
</gavern:social>
<?php endif; ?>

<?php 
	// put Google Analytics code
	echo $this->parent->social->googleAnalyticsParser(); 
?>