angular.module("forAll")
	.filter("datefilter", function($filter) {

		return function(input) {

			let output = input.split(" ")[0];
			output = output.split("-").reverse().join("-");
			return output;

		};

	});