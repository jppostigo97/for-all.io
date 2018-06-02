angular.module("forAll.admin")
	.component("adminUsers", {
		templateUrl: "views/dynamic/adm-users.php",
		controller: function($http) {
			this.roles = [];
			this.users = [];

			this.getUsers = () => {
				$http.get("api/users").then((response) => {
					this.users = response.data;
				}, (error) => {
					console.log("Error al recuperar los usuarios.");
				});
			};

			this.tryBanUser = (user) => {
				if (user.active == 1) {
					// Ban
					if (confirm("¿Banear al usuario " + user.nick + "?")) {
						$http.get("api/ban_user/" + user.id).then((response) => {
							if (response.data.banned == "true") {
								for (let u of this.users)
									if (u.id == user.id) u.active = 0;
							}
						}, (error) => {
							console.log("Error al banear al usuario " + user.nick);
						});
					}
				} else {
					// Readmitir
					if (confirm("¿Readmitir al usuario " + user.nick + "?")) {
						$http.get("api/ban_user/" + user.id).then((response) => {
							if (response.data.banned == "false") {
								for (let u of this.users)
									if (u.id == user.id) u.active = 1;
							}
						}, (error) => {
							console.log("Error al readmitir al usuario " + user.nick);
						});
					}
				}
			};

			this.getUsers();
		}
	});