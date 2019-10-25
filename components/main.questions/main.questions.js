angular.module('CyberChallenge')
.controller('main.questionsController', ['$timeout', '$q', '$scope', '$state', '$sce','categoryService','questionService',
	mainQUestionsController
]);
function mainQUestionsController($timeout, $q, $scope, $state,$sce,categoryService,questionService) {
    var vm = this;

		vm.questions = [];
		vm.categories = [];
		vm.query = {
	    order: 'category.name',
	    limit: 5,
	    page: 1,
			filter: '',
	  };

		function getAllCategories() {
			categoryService.getAllCategories().then(function(response) {
				vm.categories = response;
			});
		}
		getAllCategories();


		vm.getAllQuestions = function() {
			vm.promise = questionService.getQuestions().then(function(response) {
				vm.questions = response;
			});
		}
		vm.getAllQuestions();

}
