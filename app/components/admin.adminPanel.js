angular.module("forAll.admin")

	.config(function($locationProvider, $routeProvider) {

		$locationProvider.html5Mode({
			enabled: false,
			requireBase: false,
			rewriteLinks: false
		}).hashPrefix("");

		$routeProvider
		.when("/",  { template: "<admin-config></admin-config>"})
		.when("/config",  { template: "<admin-config></admin-config>"})
		.when("/forums",  { template: "<admin-forums></admin-forums>"})
		.when("/threads", { template: "<admin-threads></admin-threads>"})
		.when("/users",   { template: "<admin-users></admin-users>"})
		.otherwise("/");
	})
	
	.component("adminPanel", {
		templateUrl: "views/dynamic/adm-panel.php"
	});