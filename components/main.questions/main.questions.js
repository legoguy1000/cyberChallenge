angular.module('CyberChallenge')
.controller('main.questionsController', ['$timeout', '$q', '$scope', '$state', '$sce','categoryService','questionService','$mdDialog','$mdToast',
	mainQUestionsController
]);
function mainQUestionsController($timeout, $q, $scope, $state,$sce,categoryService,questionService,$mdDialog,$mdToast) {
    var vm = this;

		vm.questions = [];
		vm.categories = [];
		vm.query = {
	    order: 'category.name',
	    limit: 5,
	    page: 1,
			filter: '',
	  };

		vm.getAllQuestions = function() {
			vm.promise = questionService.getQuestions().then(function(response) {
				vm.questions = response;
			});
		}
		vm.getAllQuestions();

		vm.deleteQuestion = function(question) {
			var question_id = question.question_id;
			vm.promise = questionService.deleteQuestion(question_id).then(function(response) {
				$mdToast.show(
					$mdToast.simple()
						.textContent(response.msg)
						.position('top right')
						.hideDelay(3000)
				);
				if(response.status) {
					vm.getAllQuestions();
				}
			});
		}

		vm.showQuestionDialog = function(ev, newQuestion, question) {
			$mdDialog.show({
				controller: questionDialogController,
				controllerAs: 'vm',
				templateUrl: 'components/questionDialog/questionDialog.html',
				parent: angular.element(document.body),
				targetEvent: ev,
				clickOutsideToClose:true,
				fullscreen: true, // Only for -xs, -sm breakpoints.
				locals: {
					questionInfo: {
						new: newQuestion,
						data: newQuestion ? {} : question,
					},
				}
			})
			.then(function(response) {
				vm.getAllQuestions();
			}, function() { });
		}

}
