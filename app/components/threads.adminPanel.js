angular.module("forAll.admin")
	.component("adminThreads", {
		templateUrl: "views/dynamic/adm-threads.php",
		controller: function($http) {

			this.threads = "";

			this.getLastThreads = () => {
				$http.get("api/threads").then((response) => {
					this.threads = response.data;
				}, (error) => {
					console.log("No se han podido recuperar los hilos de conversación");
				});
			};

			this.deleteThread = (thread) => {
				if (confirm("¿Eliminar este hilo junto con sus mensajes?")) {
					$http.get("api/delete_thread/" +  thread.id).then((response) => {
						if (typeof response.data.deleted != "undefined" &&
							response.data.deleted == "true") {
							for (let i in this.threads) {
								if (this.threads[i].id == thread.id) this.threads.splice(i, 1);
							}
						}
					}, (error) => {
						console.log("No se ha podido eliminar el hilo.");
					});
				}
			};

			this.getLastThreads();
		}
	});