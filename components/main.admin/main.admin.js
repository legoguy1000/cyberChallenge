angular.module('CyberChallenge')
.controller('main.adminController', ['$timeout', '$q', '$scope', '$state', '$sce','categoryService','questionService','$mdDialog','$mdToast','quizService',
	mainAdminController
]);
function mainAdminController($timeout, $q, $scope, $state,$sce,categoryService,questionService,$mdDialog,$mdToast,quizService) {
    var vm = this;

		vm.questions = [];
		vm.categories = [];
		vm.query = {
	    order: 'category.name',
	    limit: 5,
	    page: 1,
			filter: '',
	  };
		vm.quizParams = {
			'categories': [],
			'difficulty': [],
			'question_count': null,
			'time': null,
		};

		vm.getAllQuestions = function() {
			vm.promise = questionService.getQuestions().then(function(response) {
				vm.questions = response;
			});
		}
		vm.getAllQuestions();

		function getAllCategories() {
			categoryService.getAllCategories().then(function(response) {
				vm.categories = response;
			});
		}
		getAllCategories();

		vm.getQuiz = function() {
			quizService.getQuiz().then(function(response) {
				if(response != null) {
					vm.quizParams = response;
				}
			});
		}
		vm.getQuiz();

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
			.then(function() {
				vm.getAllQuestions();
			}, function() { });
		}

		vm.submitQuiz = function() {
			vm.loading = true;
			quizService.createQuiz(vm.quizParams).then(function(response) {
				$mdToast.show(
					$mdToast.simple()
						.textContent(response.msg)
						.position('top right')
						.hideDelay(3000)
				);
				vm.loading = false;
			});
		}

		vm.deleteQuiz = function() {
			vm.loading = true;
			quizService.deleteQuiz().then(function(response) {
				if(response.status) {
					vm.quizParams = {
						'categories': null,
						'difficulty': null,
						'question_count': null,
						'time': null,
					};
					vm.quizForm.$setPristine();
				}
				$mdToast.show(
					$mdToast.simple()
						.textContent(response.msg)
						.position('top right')
						.hideDelay(3000)
				);
				vm.loading = false;
			});
		}
}
