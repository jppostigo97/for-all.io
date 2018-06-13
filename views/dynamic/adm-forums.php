<div id="admin-forums">
	<h2>Foros y subforos</h2>

	<modal-opener target="create-forum"><i class="fa fa-plus"></i></modal-opener>
	
	<div class="forum" ng-repeat="forum in $ctrl.forums track by $index">

		<h3 class="forum-title">
			{{ forum.title }}
		</h3>
		
		<p class="forum-description">{{ forum.description }}</p>
		
		<div class="action-buttons">
			<modal-opener ng-click="$ctrl.newSubforumParent = forum.id" target="create-subforum">
				<i class="fa fa-plus"></i>
			</modal-opener>

			<modal-opener ng-click="$ctrl.editForum(forum.id)" target="edit-forum">
				<i class="fa fa-pen-square"></i>
			</modal-opener>

			<button ng-click="$ctrl.deleteForum(forum)">
				<i class="fa fa-trash"></i>
			</button>
		</div>

		<ul class="forum-subforums">
			<li class="subforum" ng-repeat="subforum in forum.subforums">

				<a href="forum/show/{{ subforum.id }}">{{ subforum.title }}</a>
				
				<p>{{ subforum.description }}</p>

				<div class="action-buttons">
					<modal-opener ng-click="$ctrl.editSubforum(forum.id, subforum.id)" target="edit-subforum">
						<i class="fa fa-pen-square"></i>
					</modal-opener>

					<button ng-click="$ctrl.deleteSubforum(forum.id, subforum)">
						<i class="fa fa-trash"></i>
					</button>
				</div>

			</li>
		</ul>

	</div>
</div>

<!-- Modals -->

<div id="create-forum" class="modal">

	<div class="modal-container">
		<div class="modal-header">
			<span class="modal-title">Nuevo foro</span>
			<span class="close">&times;</span>
		</div>

		<div class="modal-content">
			
			<form action="api/create_forum" method="POST">

				<div class="form-field">
					<label for="title">Título</label>
					<input type="text" name="title" required maxlength="255" minlength="5" />
				</div>

				<div class="form-field">
					<label for="description">Descripción</label>
					<input type="text" name="description" required maxlength="255" minlength="5" />
				</div>

				<div>
					<button type="submit">Crear</button>
				</div>

			</form>

		</div>
	</div>

</div>



<div id="edit-forum" class="modal">

	<div class="modal-container">
		<div class="modal-header">
			<span class="modal-title">Editar foro</span>
			<span class="close">&times;</span>
		</div>

		<div class="modal-content">

			<form ng-submit="$ctrl.editForum().save()" method="POST">

				<div class="form-field">
					<label for="title">Título</label>
					<input type="text" name="title" ng-model="$ctrl.params.editForum.title"
						maxlength="255" minlength="5" />
				</div>

				<div class="form-field">
					<label for="description">Descripción</label>
					<input type="text" name="description"
						ng-model="$ctrl.params.editForum.description"
						maxlength="255" minlength="5" />
				</div>

				<div>
					<button type="submit">Guardar</button>
				</div>

			</form>
			
		</div>
	</div>

</div>


<div id="create-subforum" class="modal">
	<div class="modal-container">

		<div class="modal-header">
			<span class="modal-title">
				Nuevo subforo
			</span>
			
			<span class="close">&times;</span>
		</div>

		<div class="modal-content">
		
			<form ng-submit="$ctrl.saveSubforum.new()" method="POST">
			
				<div class="form-field">
					<label for="title">Título</label>
					<input type="text" name="title"
						maxlength="255" minlength="5" />
				</div>

				<div class="form-field">
					<label for="description">Descripción</label>
					<input type="text" name="description"
						maxlength="255" minlength="5" />
				</div>

				<div>
					<button type="submit">Crear</button>
				</div>

			</form>

		</div>

	</div>
</div>

<div id="edit-subforum" class="modal">
	<div class="modal-container">

		<div class="modal-header">
			<span class="modal-title">
				Editar subforo
			</span>
			
			<span class="close">&times;</span>
		</div>

		<div class="modal-content">

			<form ng-submit="$ctrl.saveSubforum.edit()" method="POST">
			
				<div class="form-field">
					<label for="title">Título</label>
					<input type="text" name="title" ng-model="$ctrl.params.editSubforum.title"
						maxlength="255" minlength="5" />
				</div>

				<div class="form-field">
					<label for="description">Descripción</label>
					<input type="text" name="description"
						ng-model="$ctrl.params.editSubforum.description"
						maxlength="255" minlength="5" />
				</div>

				<div>
					<button type="submit">Guardar</button>
				</div>

			</form>

		</div>

	</div>
</div>
