<?php $forumList = Connection::getConnection()->query("SELECT * FROM forum ORDER BY ordered;"); ?>

<?php if ($forumList->num_rows): ?>

	<section id="forum-list">

		<?php while ($forum = $forumList->fetch_assoc()): ?>

			<article class="forum" id="forum-<?= $forum["id"] ?>">
				<div class="forum-title"><?= $forum["title"] ?></div>

				<?php $subforumList = Connection::getConnection()
					->query("SELECT * FROM subforum WHERE forum=" . $forum["id"] .
					" ORDER BY ordered;"); ?>
				
				<?php if ($subforumList->num_rows): ?>

					<div class="subforum-list">

						<?php while ($subforum = $subforumList->fetch_assoc()): ?>

							<div class="subforum" id="subforum-<?= $subforum["id"] ?>">
								<a href="forum/show/<?= $subforum["id"] ?>" class="subforum-title">
									<?= $subforum["title"] ?>
								</a>
								<p class="subforum-description">
									<?= $subforum["description"] ?>
								</p>
							</div>

						<?php endwhile; ?>

					</div>

				<?php endif; ?>

			</article>

		<?php endwhile; ?>
	</section>

<?php else: ?>

	<h2>No hay foros que mostrar</h2>

<?php endif; ?>