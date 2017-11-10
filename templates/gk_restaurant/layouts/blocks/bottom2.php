<?php

// No direct access.
defined('_JEXEC') or die;

$bottom_7_12_columns = $this->generateColumnsBlock(6, 'bottom', 'bottom2', 7);

?>
	
<?php if($this->API->modules('bottom7 + bottom8 + bottom9 + bottom10 + bottom11 + bottom12') && $bottom_7_12_columns !== null) : ?>
<section id="gkBottom2">
	<?php foreach($bottom_7_12_columns as $column) : ?>
		<?php if($column !== null && $this->API->modules($column['name'])) : ?>	
		<div id="gkBottom<?php echo $column['name']; ?>" class="gkCol <?php echo $column['class']; ?>">
			<?php $this->API->addCSSRule('#gkBottom'.$column['name'].' { width: ' . $column['width'] . '%; }'); ?>
			<jdoc:include type="modules" name="<?php echo $column['name']; ?>" style="<?php echo $this->module_styles[$column['name']]; ?>" />
        </div>
		<?php endif; ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>