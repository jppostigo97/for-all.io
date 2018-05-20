<div id="subforum">
	<div id="subforum-title">
		<h2>[[ subforum_title ]]</h2>

		<?php if (isset($_SESSION["user"])): ?>
			<a href="thread/new/[[ subforum_id ]]" class="btn">
				<span>
					<i class="fas fa-sm fa-fw fa-plus"></i>
				</span>
				<span>
					Crear hilo
				</span>
			</a>
		<?php endif; ?>
	</div>

	<?php
		$query = "SELECT t.id as id, t.title as title, u.id as userid, u.nick as user " .
					"FROM thread as t JOIN user as u ON t.creator=u.id " .
					"WHERE t.subforum=${subforum_id} ORDER BY t.id DESC;";
		$threadList = Connection::getConnection()->query($query);
	?>

	<?php if ($threadList->num_rows): ?>
		<div id="thread-list">
			<?php while ($thread = $threadList->fetch_assoc()): ?>

				<?php $lastMessageAuthor = Connection::getConnection()
					->query("SELECT user.id, user.nick FROM user LEFT JOIN message ON user.id=message.author " .
						"WHERE message.thread=" . $thread["id"] ." ORDER BY message.id DESC;")
					->fetch_assoc()["nick"]; ?>

				<div class="thread">
					<a class="thread-title" href="thread/show/<?= $thread["id"] ?>">
						<?= $thread["title"] ?>
					</a>

					<div class="thread-creator">
						Escrito por
						<a href="user/profile/<?= $thread["user"] ?>" class="user-link">
							<?= $thread["user"] ?>
						</a>
					</div>

					<div class="thread-last-post">
						Último mensaje: <a href="user/profile/<?= $lastMessageAuthor ?>" class="user-link"><?= $lastMessageAuthor ?></a>
					</div>
				</div>

			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>
