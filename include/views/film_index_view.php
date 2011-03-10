<?php foreach ($data as $film) : ?>

<a href = '<?php echo $film->getPath(); ?>'><?php echo $film->getTitle(); ?></a><br>

<?php endforeach; ?>