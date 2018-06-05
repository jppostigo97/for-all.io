angular.module("forAll.admin")
	.component("adminForums", {
		templateUrl: "views/dynamic/adm-forums.php",
		controller: function($http) {
			this.forums = [];

			this.params = {};

			this.newSubforumParent = null;

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

			this.editForum = (forumId) => {
				if (!forumId) {
					return {
						save: () => {
							let p = this.params.editForum;
							if (typeof p.id != "undefined" && typeof p.title != "undefined" &&
								typeof p.description != "undefined" && p.id != 0 &&
								p.title !== "" && p.description != "") {
								let f = document.querySelector("#edit-forum form");

								f.action =
									"api/edit_forum/" + p.id;
								f.submit();
							} else {
								alert("No puedes dejar ningún campo vacío.");
							}
						}
					};
				}
				
				this.params.editForum = {};
				
				for (let forum of this.forums) {
					if (forum.id == forumId) {
						this.params.editForum =  {
							id: forum.id,
							title: forum.title,
							description: forum.description
						};
						break;
					}
				}
			};

			this.deleteForum = (forum) => {
				if (confirm("¿Eliminar el foro " + forum.title + " junto con sus subforos?")) {
					$http.get("api/delete_forum/" + forum.id).then((response) => {
						if (response.data.deleted && response.data.deleted == "true") {
							for (let i in this.forums) {
								if (this.forums[i].id == forum.id) this.forums.splice(i, 1);
							}
						}
					}, (error) => {
						alert("No se ha podido eliminar el foro.");
					});
				}
			};

			this.saveSubforum = {
				new: () => {
					if (this.newSubforumParent != null) {
						let f = document.querySelector("#create-subforum form");

						f.action = "api/create_subforum/" + this.newSubforumParent;
						f.submit();
					} else {
						alert("No ha sido posible crear un nuevo subforo.");
					}
				},
				edit: () => {
					let p = this.params.editSubforum;
					if (typeof p.id != "undefined" && typeof p.title != "undefined" &&
						typeof p.description != "undefined" && p.id != 0 &&
						p.title !== "" && p.description != "") {
						let f = document.querySelector("#edit-subforum form");

						f.action = "api/edit_subforum/" + p.id;
						f.submit();
					} else {
						alert("No puedes dejar ningún campo vacío.");
					}
				}
			};

			this.editSubforum = (forumId, subforumId) => {
				this.params.editSubforum = {};
				
				for (let forum of this.forums) {
					if (forum.id == forumId) {
						for (let sub of forum.subforums) {
							if (sub.id == subforumId) {
								this.params.editSubforum =  {
									id: sub.id,
									title: sub.title,
									description: sub.description
								};
								break;
							}
						}
						break;
					}
				}
			};

			this.deleteSubforum = (forumId, subforum) => {
				if (confirm("¿Eliminar el subforo " + subforum.title + "?")) {
					$http.get("api/delete_subforum/" + subforum.id).then((response) => {
						if (response.data.deleted && response.data.deleted == "true") {
							for (let i in this.forums) {
								if (this.forums[i].id == forumId) {
									for (let j in this.forums[i].subforums) {
										if (this.forums[i].subforums[j].id == subforum.id)
											this.forums[i].subforums.splice(j, 1);
									}
								}
							}
						}
					}, (error) => {
						alert("No se ha podido eliminar el subforo.");
					});
				}
			};

			this.getForums();
		}
	});