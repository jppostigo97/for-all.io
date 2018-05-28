<div id="admin-config">
	<h2>Configuración</h2>

	<div id="config-list">

		<form action="admin/validate_config" method="POST">
			<div class="form-field">
				<label for="def_role">Rol de usuario predeterminado</label>
				<select name="def_role" id="def_role">
					<option value="{{ role.slug }}" ng-repeat="role in $ctrl.roles" ng-if="role.slug == $ctrl.default" selected="selected">{{ role.name }}</option>
					<option value="{{ role.slug }}" ng-repeat="role in $ctrl.roles" ng-if="role.slug != $ctrl.default">{{ role.name }}</option>
				</select>
			</div>
			<div>
				<button type="submit">Guardar</button>
			</div>
		</form>
	</div>
</div>