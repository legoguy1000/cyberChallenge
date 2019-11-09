angular.module('CyberChallenge')
.controller('questionDialogController', ['$timeout', '$q', '$scope', '$state', '$sce','categoryService','questionService','$mdDialog','questionInfo','$mdToast',
	questionDialogController
]);
function questionDialogController($timeout, $q, $scope, $state,$sce,categoryService,questionService,$mdDialog,questionInfo,$mdToast) {
	var vm = this;
	vm.cancel = function() {
		$mdDialog.cancel();
	}

	vm.new = questionInfo.new && questionInfo.data.question_id == undefined;
	vm.data = vm.new ? {category_id:''} : angular.copy(questionInfo.data);

	vm.addQuestion = function() {
		var data = {
			'category_id': vm.data.category_id,
			'hint_1': vm.data.hint_1,
			'hint_2': vm.data.hint_2,
			'hint_3': vm.data.hint_3,
			'difficulty': vm.data.difficulty,
			'answers': vm.data.answers,
		}
		questionService.addQuestion(data).then(function(response) {
			after(response);
		});
	}

	vm.updateQuestion = function() {
		var data = {
			'question_id': vm.data.question_id,
			'category_id': vm.data.category_id,
			'hint_1': vm.data.hint_1,
			'hint_2': vm.data.hint_2,
			'hint_3': vm.data.hint_3,
			'difficulty': vm.data.difficulty,
			'answers': vm.data.answers,
		}
		questionService.updateQuestion(data).then(function(response) {
			 after(response);
		});
	}

	function after(response) {
		if(response.status) {
			$mdDialog.hide(response);
		}
		$mdToast.show(
			$mdToast.simple()
				.textContent(response.msg)
				.position('top right')
				.hideDelay(3000)
		);
	}

	vm.submitForm = function() {
		if(vm.data.category_id == '') {
			return;
		}
		if(vm.new) {
			vm.addQuestion();
		} else {
			vm.updateQuestion();
		}
	}


	vm.categories = [];
	vm.questions = [];
	function getAllCategories() {
		categoryService.getAllCategories().then(function(response) {
			vm.categories = response;
		});
	}
	getAllCategories();


}
