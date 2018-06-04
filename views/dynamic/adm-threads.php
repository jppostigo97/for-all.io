<div id="admin-threads">
	<h2>Hilos</h2>
	
	<div class="thread" ng-repeat="thread in $ctrl.threads">

		<div class="thread-info">
			<a href="thread/show/{{ thread.id }}" class="thread-title">
				{{ thread.title }}
			</a>
			por
			<a href="user/profile/{{ thread.author }}">{{ thread.author }}</a>
			en
			<a href="forum/show/{{ thread.subforum }}">{{ thread.subforumTitle }}</a>
		</div>

		<button ng-click="$ctrl.deleteThread(thread)" class="delete">
			<i class="fa fa-fw fa-trash"></i>
		</button>
		
		<div class="thread-more-info">
			Fecha: {{ thread.creation | datefilter }} - {{ thread.creation | timefilter }}
		</div>

	</div>
</div>