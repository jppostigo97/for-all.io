angular.module("forAll.admin", ["ngResource", "ngRoute"])

.config(["$locationProvider", "$routeProvider", function($locationProvider, $routeProvider) {
	$locationProvider.html5Mode({
		enabled: true,
		requireBase: false,
		rewriteLinks: true
	}).hashPrefix("");

	$routeProvider
	.when("/config", { template: "<admin-config></admin-config>"})
	.when("/forums", { template: "<admin-forums></admin-forums>"})
	.when("/threads", { template: "<admin-threads></admin-threads>"})
	.when("/users", { template: "<admin-users></admin-users>"})
	.otherwhise("/config");
}])
;