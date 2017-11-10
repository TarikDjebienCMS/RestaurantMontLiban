<?php

// No direct access.
defined('_JEXEC') or die;
?>

<footer>
	<?php if($this->API->modules('footer_nav')) : ?>
	<nav>
		<jdoc:include type="modules" name="footer_nav" style="<?php echo $this->module_styles['footer_nav']; ?>" />
	</nav>
	<?php endif; ?>
	
	<?php if(isset($_COOKIE['gkGavernMobile_'.$this->parent->name]) && $_COOKIE['gkGavernMobile_'.$this->parent->name] == 'desktop') : ?>
		<span class="mobileSwitch">
			<a href="javascript:setCookie('gkGavernMobile_<?php echo $this->parent->name; ?>', 'mobile', 365);window.location.reload();">
				<?php echo JText::_('TPL_GK_LANG_SWITCH_TO_MOBILE'); ?>
			</a>
		</span>
	<?php endif; ?>
		
	<?php if($this->API->get('copyrights', '') !== '') : ?>
	<p><?php echo $this->API->get('copyrights', ''); ?></p>
	<?php else : ?>
	<p>Template Design &copy; <a href="http://www.gavick.com" title="Joomla Templates">Joomla Templates</a> | GavickPro. All rights reserved.</p>
	<?php endif; ?>
</footer>

<?php if($this->API->get('framework_logo', '0') == '1') : ?>
<a href="http://gavick.com" id="gkFrameworkLogo" title="Gavern Framework">Gavern Framework</a>
<?php endif; ?>

<?php if($this->API->get('stylearea', '0') == '1') : ?>
<div id="gkStyleArea">
    <a href="#" id="gkColor1"><?php echo JText::_('TPL_GK_LANG_COLOR_1'); ?></a>
    <a href="#" id="gkColor2"><?php echo JText::_('TPL_GK_LANG_COLOR_2'); ?></a>
    <a href="#" id="gkColor3"><?php echo JText::_('TPL_GK_LANG_COLOR_3'); ?></a>
</div>
<?php endif; ?>