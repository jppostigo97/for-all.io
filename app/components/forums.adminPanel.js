angular.module("forAll.admin")
	.component("adminForums", {
		templateUrl: "views/dynamic/adm-forums.php",
		controller: function($http) {
			this.forums = [];

			this.getForums = () => {
				$http.get("api/forums").then((response) => {
					let forumList = response.data;

					for (let forum of forumList) {
						$http.get("api/subforums/" + forum.id).then((response) => {
							let f = forum;
							f.subforums = response.data;
							this.forums.push(f);
						}, (error) => {
							console.log("Error al recuperar los subforos de " + forum.title);
						});
					}
				}, (error) => {
					console.log("Error al recuperar los foros");
				});
			};

			this.getForums();
		}
	});