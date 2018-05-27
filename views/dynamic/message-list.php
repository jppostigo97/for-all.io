<div id="message-list">
	<div class="message" ng-repeat="msg in $ctrl.messages">
		<div class="message-info">
			<div class="message-author">
				<img src="assets/img/{{ msg.author }}.jpg" alt="Imagen de perfil"
					ng-if="msg.profile == 'y'" class="profile-pic" />
				<img src="assets/img/default_profile_image.png" alt="Imagen de perfil"
					ng-if="msg.profile == 'n'" class="profile-pic" />
				<span><a href="user/profile/{{ msg.author }}">{{ msg.author }}</a></span>
			</div>
		</div>

		<div class="message-content">{{ msg.content }}</div>

		<div class="clearfix"></div>
	</div>
</div>

<div id="thread-more">
	<ul id="thread-pagination" ng-if="$ctrl.pages.length > 1">
		<li ng-repeat="page in $ctrl.pages">
			<a ng-click="$ctrl.clickButton(page)" data-page="{{ page }}">{{ page }}</a>
		</li>
	</ul>
</div>
