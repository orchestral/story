<div class="box white rounded list-group no-padding">
	<?php foreach ($posts as $post) : ?>
	<a href="<?php echo $post->link; ?>" class="list-group-item"><?php echo $post->title; ?></a>
	<?php endforeach; ?>
</div>
