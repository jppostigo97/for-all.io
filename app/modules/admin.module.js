angular.module("forAll.admin", ["ngRoute"])

.config(function($locationProvider, $routeProvider) {

	$locationProvider.html5Mode({
		enabled: false,
		requireBase: false,
		rewriteLinks: false
	}).hashPrefix("");

	$routeProvider
	.when("/",  { template: "<adm-config></adm-config>"})
	.when("/config",  { template: "<adm-config></adm-config>"})
	.when("/forums",  { template: "<adm-forums></adm-forums>"})
	.when("/threads", { template: "<adm-threads></adm-threads>"})
	.when("/users",   { template: "<adm-users></adm-users>"})
	.otherwise("/");
})
;
