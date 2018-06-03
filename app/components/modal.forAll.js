angular.module("forAll")
	.component("modalOpener", {
		template: "<button ng-click='$ctrl.openModal()' class='modal-opener'>{{ $ctrl.text }}</button>",
		controller: function() {

			this.openModal = () => {
				let closeButton = document.querySelector("#" + this.target + " span.close");
				var modal       = document.querySelector(".modal#" + this.target);

				modal.style.display = "block";

				window.onclick = function(e) {
					if (e.target == modal) modal.style.display = "none";
				};

				closeButton.onclick = function() {
					modal.style.display = "none";
				}
			};
		},
		bindings: {
			text: "@",
			target: "@"
		}
	});