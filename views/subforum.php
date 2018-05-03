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
		echo Connection::getConnection()->error;
	?>
	
	<?php if ($threadList->num_rows): ?>
		<div id="thread-list">
			<?php while ($thread = $threadList->fetch_assoc()): ?>

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
						Último mensaje: <a href="" class="user-link">yo</a>
					</div>
				</div>

			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>