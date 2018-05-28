angular.module("forAll.admin")
	.component("adminConfig", {
		templateUrl: "views/dynamic/adm-config.php",
		controller: function($http) {
			this.roles = [];
			this.default = "";

			$http.get("api/roles").then((response) => {
				this.roles = response.data;
			}, (error) => {
				console.log("No se ha podido obtener la lista de roles de usuario.");
			});

			$http.get("api/default_role").then((response) => {
				this.default = response.data.value;
			}, (error) => {
				console.log("No se ha podido obtener el rol predeterminado.");
			});
		}
	});