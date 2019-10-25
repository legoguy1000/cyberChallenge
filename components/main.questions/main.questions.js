angular.module('CyberChallenge')
.controller('main.questionsController', ['$timeout', '$q', '$scope', '$state', '$sce','categoryService','questionService',
	mainQUestionsController
]);
function mainQUestionsController($timeout, $q, $scope, $state,$sce,categoryService,questionService) {
    var vm = this;

		vm.questions = [];
		vm.categories = [];

		function getAllCategories() {
			categoryService.getAllCategories().then(function(response) {
				vm.categories = response;
			});
		}
		getAllCategories();


		function getAllQuestions() {
			questionService.getQuestions().then(function(response) {
				vm.questions = response;
			});
		}
		getAllQuestions();

}
