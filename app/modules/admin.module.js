angular.module("forAll.admin", ["ngRoute"])

.config(["$routeProvider", function($routeProvider) {

	$routeProvider
	.when("/config",  { template: "<admin-config></admin-config>"})
	.when("/forums",  { template: "<admin-forums></admin-forums>"})
	.when("/threads", { template: "<admin-threads></admin-threads>"})
	.when("/users",   { template: "<admin-users></admin-users>"})
	.otherwhise("/config");
}])
;
