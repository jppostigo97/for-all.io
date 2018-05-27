<?php
	$threadQuery = "SELECT thread.id as id, thread.title as thread, " .
		"subforum.id as sfid, subforum.title as subforum FROM thread " .
		"JOIN subforum ON thread.subforum=subforum.id WHERE thread.creator=$userId;";
	$threadList  = Connection::getConnection()->query($threadQuery);

	$messageQuery = "SELECT * FROM message WHERE author=$userId ORDER BY id DESC LIMIT 0,5;";
	$messageList  = Connection::getConnection()->query($messageQuery);
?>

<div id="profile">
	<h2 id="profile-info">
		[[ username ]]
		-
		<small>[[ role ]]</small>
	</h2>

	<?php if (isset($_SESSION["user"]) && $_SESSION["user"] == $username): ?>
		<div id="edit-profile">
			<a href="user/edit_profile" class="btn">Editar</a>
		</div>
	<?php endif; ?>

	<div id="activity">
		<?php if ($threadList): ?>
			<div id="thread-list">

				<h3>Hilos abiertos</h3>

				<?php while ($thread = $threadList->fetch_assoc()): ?>

					<div class="thread">
						<a class="thread-title" href="thread/show/<?= $thread["id"] ?>">
							<?= $thread["thread"] ?>
						</a>
						&gt;
						<a class="thread-subforum" href="forum/show/<?= $thread["sfid"] ?>">
							<?= $thread["subforum"] ?>
						</a>
					</div>

				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<?php if ($messageList): ?>
			<div id="message-list">

				<h3>Últimos mensajes</h3>

				<?php while ($msg = $messageList->fetch_assoc()): ?>

					<div class="message">
						<div class="message-content">
							<?php

								if (strlen($msg["content"]) > 140) echo substr($msg["content"], 0, 120) . "...";
								else echo $msg["content"];

							?>
							<br />
							<a class="read-more btn" href="thread/show/<?= $msg["thread"] ?>">
								Seguir leyendo
							</a>
						</div>
						<div class="clearfix"></div>
					</div>

				<?php endwhile; ?>

			</div>
		<?php endif; ?>
	</div>
</div>
