<?php

// No direct access.
defined('_JEXEC') or die;

?>
<section class="gkColumns">
	<?php if($this->API->modules('left')) : ?>
	<aside id="gkLeft">
		<jdoc:include type="modules" name="left" style="<?php echo $this->module_styles['left']; ?>" />
	</aside>
	<?php endif; ?>
	
	<section id="gkContent">
		<?php if($this->API->modules('breadcrumb') || $this->parent->getToolsOverride()) : ?>
		<section id="gkBreadcrumb">
			<?php if($this->API->modules('breadcrumb')) : ?>
			<jdoc:include type="modules" name="breadcrumb" style="<?php echo $this->module_styles['breadcrumb']; ?>" />
			<?php endif; ?>
			
			<?php if($this->parent->getToolsOverride()) : ?>
				<?php $this->loadBlock('tools/tools'); ?>
			<?php endif; ?>
		</section>
		<?php endif; ?>
	
		<?php if($this->API->modules('top')) : ?>
		<section id="gkContentTop">
			<jdoc:include type="modules" name="top" style="<?php echo $this->module_styles['top']; ?>" />
		</section>
		<?php endif; ?>
		
		<section id="gkContentMainbody">
			<?php if($this->API->modules('inset1')) : ?>
			<aside id="gkInset1">
				<jdoc:include type="modules" name="inset1" style="<?php echo $this->module_styles['inset1']; ?>" />
			</aside>
			<?php endif; ?>			
			
			<section id="gkComponentWrap">	
				<?php if($this->API->modules('mainbody_top')) : ?>
				<section id="gkMainbodyTop">
					<jdoc:include type="modules" name="mainbody_top" style="<?php echo $this->module_styles['mainbody_top']; ?>" />
				</section>
				<?php endif; ?>	
				
				<section id="gkMainbody">
					<?php if(($this->isFrontpage() && !$this->API->modules('mainbody')) || !$this->isFrontpage()) : ?>
						<jdoc:include type="component" />
					<?php else : ?>
						<jdoc:include type="modules" name="mainbody" style="<?php echo $this->module_styles['mainbody']; ?>" />
					<?php endif; ?>
				</section>
				
				<?php if($this->API->modules('mainbody_bottom')) : ?>
				<section id="gkMainbodyBottom">
					<jdoc:include type="modules" name="mainbody_bottom" style="<?php echo $this->module_styles['mainbody_bottom']; ?>" />
				</section>
				<?php endif; ?>
			</section>
				
			<?php if($this->API->modules('inset2')) : ?>
			<aside id="gkInset2">
				<jdoc:include type="modules" name="inset2" style="<?php echo $this->module_styles['inset2']; ?>" />
			</aside>
			<?php endif; ?>	
		</section>
		
		<?php if($this->API->modules('bottom')) : ?>
		<section id="gkContentBottom">
			<jdoc:include type="modules" name="bottom" style="<?php echo $this->module_styles['bottom']; ?>" />
		</section>
		<?php endif; ?>
		
		<?php $this->loadBlock('user'); ?>
	</section>
	
	<?php if($this->API->modules('right')) : ?>
	<aside id="gkRight">
		<jdoc:include type="modules" name="right" style="<?php echo $this->module_styles['right']; ?>" />
	</aside>
	<?php endif; ?>
</section>