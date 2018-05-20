<?php
	$messages = Connection::getConnection()->query("SELECT * FROM message WHERE thread=${thread};");
?>

<div id="thread">
	<h2 id="thread-title">[[ title ]]</h2>

	<div id="message-list">
		<?php while($msg = $messages->fetch_assoc()): ?>
			<?php $author = Connection::getConnection()->query("SELECT * FROM user WHERE id=" .
				$msg["author"] . ";")->fetch_assoc()["nick"]; ?>

			<div class="message" id="message-<?= $msg["id"] ?>">
				<div class="message-info">
					<div class="message-author">
						<?php if (file_exists("assets/img/" . $msg["author"] . ".jpg")): ?>
							<img src="assets/img/<?= $msg["author"] ?>" alt="<?= $author ?>" />
						<?php else: ?>
							<img src="assets/img/default_profile_image.png"
								alt="<?= $author ?>" class="profile-pic" />
						<?php endif; ?>
						<span><?= $author ?></span>
					</div>
				</div>

				<div class="message-content"><?= $msg["content"] ?> <!-- Parsear en caso de que sea necesario --></div>

				<div class="clearfix"></div>
			</div>

		<?php endwhile; ?>
	</div>

	<div id="thread-more">
		<a href="thread/answer/[[ thread ]]" class="btn" id="thread-answer">Responder</a>

		<!-- Integrar Angular o Vue si es posible para paginar -->
		<!-- <ul id="thread-pagination">
		</ul> -->
		<!-- / Paginación AJAX Dinámica -->
	</div>
</div>
