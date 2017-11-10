<?php

/**
 *
 * Default view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;
// 
$this->layout->generateColumnsWidth();
$this->layout->generateLayout(20);
//
$app = JFactory::getApplication();
$user = JFactory::getUser();
// getting User ID
$userID = $user->get('id');
// getting params
$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
// defines if login is active
define('GK_LOGIN', $this->API->modules('login'));
// defines if com_users
define('GK_COM_USERS', $option == 'com_users' && ($view == 'login' || $view == 'registration'));
// other variables
$btn_login_text = ($userID == 0) ? JText::_('TPL_GK_LANG_LOGIN') : JText::_('TPL_GK_LANG_LOGOUT');
$tpl_page_suffix = $this->page_suffix != '' ? ' class="'.$this->page_suffix.'"' : '';

?>
<!DOCTYPE html>
<html lang="<?php echo $this->APITPL->language; ?>">
<head>
    <?php if($this->API->get("chrome_frame_support", '0') == '1' && ($this->browser->get('browser') == 'ie8' || $this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6')) : ?>
    <meta http-equiv="X-UA-Compatible" content="chrome=1"/>
    <?php endif; ?>
    <?php if($this->browser->get('browser') == 'ie8' || $this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6') : ?>
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <?php endif; ?>
    <jdoc:include type="head" />
    <?php $this->layout->loadBlock('head'); ?>
</head>
<body<?php echo $tpl_page_suffix; ?><?php if($this->browser->get("tablet") == true) echo ' data-tablet="true"'; ?>>	
	<?php if ($this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6') : ?>
	<div id="ieToolbar"><div><?php echo JText::_('TPL_GK_LANG_IE_TOOLBAR'); ?></div></div>
	<?php endif; ?>		
    <?php if(count($app->getMessageQueue())) : ?>
    <jdoc:include type="message" />
    <?php endif; ?>
    <div id="gkBg">
	    <section id="gkPageTop">                    		
		   	<div>
			    <?php $this->layout->loadBlock('logo'); ?>
		   		
		   		<section id="gkMainMenu">
		   			<?php
		   				$this->mainmenu->loadMenu($this->API->get('menu_name','mainmenu')); 
		   			    $this->mainmenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
		   			?>
		   			
		   			<?php if($this->config->get('generateSubmenu', 0) && $this->mainmenu->genMenu($this->API->get('startlevel', 0)+1, $this->API->get('endlevel',-1), true)): ?>
		   				<?php $this->mainmenu->genMenu($this->API->get('startlevel', 0)+1, $this->API->get('endlevel',-1));?>
		   			<?php endif; ?>
		   		</section>
		   		
		   		<?php if($this->API->modules('cart')) : ?>
		   		<div id="gkCart">
		   			<jdoc:include type="modules" name="cart" style="<?php echo $this->module_styles['cart']; ?>" />
		   		</div>
		   		<?php endif; ?>
	   		</div>
	    </section>
    	
    	<?php $this->layout->loadBlock('top'); ?>
    
		<section id="gkPage"> 
	    	<?php $this->layout->loadBlock('main'); ?>
	    	
	    	<?php $this->layout->loadBlock('bottom1'); ?>
	    </section>
	    
	    <?php $this->layout->loadBlock('bottom2'); ?>
	    <?php $this->layout->loadBlock('footer'); ?>
	</div> 
   
   	<?php $this->layout->loadBlock('tools/login'); ?>
   	<div id="gkPopupOverlay"></div>
   
   	<?php $this->layout->loadBlock('social'); ?>
	<jdoc:include type="modules" name="debug" />
</body>
</html>