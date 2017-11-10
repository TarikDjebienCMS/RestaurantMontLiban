<?php

// No direct access.
defined('_JEXEC') or die;

$top_1_6_columns = $this->generateColumnsBlock(6, 'top', 'top1', 1);
$top_7_12_columns = $this->generateColumnsBlock(6, 'top', 'top2', 7);

?>

<?php if($this->API->modules('top1 + top2 + top3 + top4 + top5 + top6') && $top_1_6_columns !== null) : ?>
<section id="gkTop1">
	<?php foreach($top_1_6_columns as $column) : ?>
		<?php if($column !== null && $this->API->modules($column['name'])) : ?>	
		<div id="gkTop<?php echo $column['name']; ?>" class="gkCol <?php echo $column['class']; ?>">
			<?php $this->API->addCSSRule('#gkTop'.$column['name'].' { width: ' . $column['width'] . '%; }'); ?>
			<jdoc:include type="modules" name="<?php echo $column['name']; ?>" style="<?php echo $this->module_styles[$column['name']]; ?>" />
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>

<?php if($this->API->modules('top7 + top8 + top9 + top10 + top11 + top12') && $top_7_12_columns !== null) : ?>
<section id="gkTop2">
	<?php foreach($top_7_12_columns as $column) : ?>
		<?php if($column !== null && $this->API->modules($column['name'])) : ?>	
		<div id="gkTop<?php echo $column['name']; ?>" class="gkCol <?php echo $column['class']; ?>">
			<?php $this->API->addCSSRule('#gkTop'.$column['name'].' { width: ' . $column['width'] . '%; }'); ?>
			<jdoc:include type="modules" name="<?php echo $column['name']; ?>" style="<?php echo $this->module_styles[$column['name']]; ?>" />
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>