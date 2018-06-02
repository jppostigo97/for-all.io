<div id="admin-forums">
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