
<?php echo $data['user']->getEmail(); ?><br>
<?php echo $data['user']->getHandle(); ?><br>

<?php echo $data['user']->getHandle(); ?> has seen<br>
<?php foreach ( $data['user']->getSeenFilms() as $film ) : ?>
<?php echo $film->getTitle(); ?><br>
<?php endforeach; ?>