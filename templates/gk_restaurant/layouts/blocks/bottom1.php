<?php

// No direct access.
defined('_JEXEC') or die;

$bottom_1_6_columns = $this->generateColumnsBlock(6, 'bottom', 'bottom1', 1);

?>

<?php if($this->API->modules('bottom1 + bottom2 + bottom3 + bottom4 + bottom5 + bottom6') && $bottom_1_6_columns !== null) : ?>
<section id="gkBottom1">
	<?php foreach($bottom_1_6_columns as $column) : ?>
		<?php if($column !== null && $this->API->modules($column['name'])) : ?>	
		<div id="gkBottom<?php echo $column['name']; ?>" class="gkCol <?php echo $column['class']; ?>">
			<?php $this->API->addCSSRule('#gkBottom'.$column['name'].' { width: ' . $column['width'] . '%; }'); ?>
			<jdoc:include type="modules" name="<?php echo $column['name']; ?>" style="<?php echo $this->module_styles[$column['name']]; ?>" />
        </div>
		<?php endif; ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>