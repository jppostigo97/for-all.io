angular.module("forAll.thread")
	.component("messageList", {
		templateUrl: "views/dynamic/message-list.php",
		controller: function($http) {

			let urlArray = String(window.location).split("/");

			this.page = 1;
			this.threadId = urlArray[urlArray.indexOf("show")+1];

			this.messages = [];
			this.pages    = [];

			this.goPage = (page) => {
				$http.get("api/messages/" + this.threadId + "/" + page)
				.then((response) => {
					this.messages = [];
					for (let m of response.data) {
						this.messages.push(m);
					}
				})
				.catch(function(error) {
					console.error("Error al recuperar los mensajes del hilo.");
				});
			};

			this.clickButton = (page) => {
				this.goPage(page);

				let allBtn     = document.querySelectorAll("#thread-pagination a");
				let clickedBtn = document.querySelector("a[data-page=\"" + page + "\"]");

				for (let btn of allBtn) btn.className = "";
					clickedBtn.className = "active";
			};

			this.initPages = () => {
				$http.get("api/message_pages/" + this.threadId)
				.then((response) => {
					let pageAmount = Number(response.data.pages);
					for (let i = 0; i < pageAmount; i++) this.pages[i] = i+1;
				})
				.catch(function(error) {
					console.error("Error al cargar el número de páginas.");
				});
			};

			this.init = () => {
				this.goPage(this.page);
				this.initPages();
			};

			this.init();
		}
	});
