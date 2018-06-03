<div id="admin-forums">
	<h2>Foros y subforos</h2>

	<modal-opener text="Nuevo foro" target="create-forum"></modal-opener>
	
	<div class="forum" ng-repeat="forum in $ctrl.forums">
		<h3 class="forum-title">{{ forum.title }}</h3>
		<p class="forum-description">{{ forum.description }}</p>
		<ul class="forum-subforums">
			<li class="subforum" ng-repeat="subforum in forum.subforums">
				<a href="forum/show/{{ subforum.id }}">{{ subforum.title }}	</a>
				<p>{{ subforum.description }}</p>
			</li>
		</ul>
	</div>
</div>

<div id="create-forum" class="modal">

	<div class="modal-container">
		<div class="modal-header">
			<span class="modal-title">Nuevo foro</span>
			<span class="close">&times;</span>
		</div>

		<div class="modal-content">
			
			<form action="api/create_forum" method="POST">

				<div class="form-field">
					<label for="newForumTitle">Título</label>
					<input type="text" name="title" />
				</div>

				<div class="form-field">
					<label for="newForumDescription">Descripción</label>
					<input type="text" name="description" />
				</div>

				<div>
					<button type="submit">Crear</button>
				</div>

			</form>

		</div>
	</div>

</div>