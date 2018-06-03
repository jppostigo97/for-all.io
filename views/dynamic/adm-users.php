<div id="admin-users">
	<h2>Usuarios</h2>

	<div class="table">
		<table id="user-list">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Email</th>
					<th>Rol</th>
					<th>F. Registro</th>
					<th>Última conexión</th>
					<th>Verificado</th>
					<th>Activo</th>
				</tr>
			</thead>

			<tbody>
				<tr ng-repeat="user in $ctrl.users track by $index" id="user-{{ user.id}}">
					<td>{{ user.nick }}</td>
					<td>{{ user.email }}</td>
					<td>{{ user.role }}</td>
					<td>{{ user.reg_date | datefilter }}</td>
					<td>{{ user.last_connection | datefilter }}</td>
					<td>
						<i class="fa fa-lg fa-check" ng-if="user.verified != 0"></i>
						<i class="fa fa-lg fa-times" ng-if="user.verified == 0"></i>
					</td>
					<td ng-click="$ctrl.tryBanUser(user)">
						<i class="fa fa-lg fa-check pointer" ng-if="user.active != 0"></i>
						<i class="fa fa-lg fa-times pointer" ng-if="user.active == 0"></i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</div>