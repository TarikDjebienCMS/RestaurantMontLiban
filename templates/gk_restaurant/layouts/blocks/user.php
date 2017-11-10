<?php

// No direct access.
defined('_JEXEC') or die;

$user_1_6_columns = $this->generateColumnsBlock(6, 'user', 'user1', 1);
$user_7_12_columns = $this->generateColumnsBlock(6, 'user', 'user2', 7);

?>

<?php if($this->API->modules('user1 + user2 + user3 + user4 + user5 + user6') && $user_1_6_columns !== null) : ?>
<section id="gkUser1">
	<?php foreach($user_1_6_columns as $column) : ?>
		<?php if($column !== null && $this->API->modules($column['name'])) : ?>	
		<div id="gkUser<?php echo $column['name']; ?>" class="gkCol <?php echo $column['class']; ?>">
			<?php $this->API->addCSSRule('#gkUser'.$column['name'].' { width: ' . $column['width'] . '%; }'); ?>
			<jdoc:include type="modules" name="<?php echo $column['name']; ?>" style="<?php echo $this->module_styles[$column['name']]; ?>" />
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>

<?php if($this->API->modules('user7 + user8 + user9 + user10 + user11 + user12') && $user_7_12_columns !== null) : ?>
<section id="gkUser2">
	<?php foreach($user_7_12_columns as $column) : ?>
		<?php if($column !== null && $this->API->modules($column['name'])) : ?>	
		<div id="gkUser<?php echo $column['name']; ?>" class="gkCol <?php echo $column['class']; ?>">
			<?php $this->API->addCSSRule('#gkUser'.$column['name'].' { width: ' . $column['width'] . '%; }'); ?>
			<jdoc:include type="modules" name="<?php echo $column['name']; ?>" style="<?php echo $this->module_styles[$column['name']]; ?>" />
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>