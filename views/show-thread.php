<?php
	$messages = Connection::getConnection()->query("SELECT * FROM message WHERE thread=${thread};");
?>

<div id="thread">
	<div id="thread-title">
		<h2>[[ title ]]</h2>

		<?php if (isset($_SESSION["user"])): ?>
			<a href="thread/answer/[[ thread ]]" class="btn">Responder</a>
		<?php endif; ?>
	</div>

	<message-list></message-list>
</div>
