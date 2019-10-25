angular.module('CyberChallenge')
.controller('main.quizController', ['$timeout', '$q', '$scope', '$state', '$sce','categoryService','questionService','$interval',
	mainQuizController
]);
function mainQuizController($timeout, $q, $scope, $state,$sce,categoryService,questionService,$interval) {
	var vm = this;

	vm.categories = [];
	vm.questions = [];
	vm.quizStarted = false;
	vm.quizOver = false;
	vm.currentQuestionIndex = 0;
	vm.timer = 0;
	vm.interval = null;
	vm.answers = [];
	vm.answerOptions = ['a','b','c','d'];
	vm.answerCounts = {true: 0, false: 0};
	vm.quizParams = {
		'categories': null,
		'count': 5,
		'time': 15,
	};
	function getAllCategories() {
		categoryService.getAllCategories().then(function(response) {
			vm.categories = response;
		});
	}
	getAllCategories();

	function getQuestions() {
		vm.questions = [];
		var params = {
			'categories': vm.quizParams.categories,
			'count': vm.quizParams.count,
			'random':'',
		}
		questionService.getQuestions(params).then(function(response) {
			vm.questions = response;
		});
	}
	vm.startQuiz = 	function() {
		vm.quizOver = false;
		vm.timer = vm.quizParams.time;
		vm.currentQuestionIndex = 0;
		vm.questions = [];
		var params = {
			'categories': vm.quizParams.categories,
			'count': vm.quizParams.count,
			'random':'',
		}
		questionService.getQuestions(params).then(function(response) {
			vm.questions = response;
			vm.quizStarted = true;
			for(var i=0; i<vm.questions.length; i++) {
				vm.answers.push(false);
			}
			interval();
		});
	}

	function interval() {
		vm.timer = vm.quizParams.time;
		vm.interval = $interval(function() {
			vm.timer -= 1;
			if (vm.timer == 0) {
				incrementQuestion();
			}
		}, 1000, 0, true);
	}

	function incrementQuestion() {
		$interval.cancel(vm.interval);
		if(vm.currentQuestionIndex < (vm.questions.length - 1)) {
			vm.currentQuestionIndex++;
			interval();
		} else {
			vm.quizOver = true;
			for (var i = 0; i < vm.answers.length; i++) {
			  var answer = vm.answers[i];
			  vm.answerCounts[answer] = vm.answerCounts[answer] + 1;
			}
		}
	}

	vm.answerQuestion = function(choice) {
		if(choice == vm.questions[vm.currentQuestionIndex].correct_answer) {
			vm.answers[vm.currentQuestionIndex] = true;
		} else if(vm.answerOptions.indexOf(choice) >= 0) {
			vm.answers[vm.currentQuestionIndex] = false;
		}
		incrementQuestion();
	}

	vm.startOver = function() {
		$interval.cancel(vm.interval);
		vm.questions = [];
		vm.quizStarted = false;
		vm.quizOver = false;
		vm.currentQuestionIndex = 0;
		vm.timer = 0;
		vm.interval = null;
		vm.answers = [];
		vm.answerCounts = {true: 0, false: 0};
	}

}
