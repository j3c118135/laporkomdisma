<?php if (! empty($errors)) : ?>
	<div class="errors alert alert-danger small pb-0" role="alert">
		<ul class="mb-2 pl-0">
		<?php foreach ($errors as $error) : ?>
				<li><i class='fas fa-info-circle mr-2'></i><?= esc($error) ?></li>
			<?php endforeach ?>
		</ul>
		
	</div>
<?php endif ?>
