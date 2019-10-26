angular.module('CyberChallenge')
.controller('main.quizController', ['$timeout', '$q', '$scope', '$state', '$sce','categoryService','quizService','$interval',
	mainQuizController
]);
function mainQuizController($timeout, $q, $scope, $state,$sce,categoryService,quizService,$interval) {
	var vm = this;

	vm.categories = [];
	vm.questions = [];
	vm.quizStarted = false;
	vm.quizOver = false;
	vm.currentQuestionIndex = 0;
	vm.timer = 0;
	vm.interval = null;
	vm.answers = {};
	vm.answerOptions = ['a','b','c','d'];
	vm.answerResults = {};
	vm.loading = false;
	vm.loadingMessage = '';
	vm.answersDisabled = false;
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

	vm.startQuiz = 	function() {
		vm.loadingMessage = 'Getting Questions';
		vm.loading = true;
		vm.quizOver = false;
		vm.timer = vm.quizParams.time;
		vm.currentQuestionIndex = 0;
		vm.questions = [];
		var params = {
			'categories': vm.quizParams.categories,
			'count': vm.quizParams.count,
		}
		quizService.getQuestions(params).then(function(response) {
			vm.questions = response;
			vm.quizStarted = true;
			vm.loading = false;
			for(var i=0; i<vm.questions.length; i++) {
				vm.answers[vm.questions[i].question_id] = null;
			}
			console.log(vm.answers);
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
			vm.answersDisabled = false;
		} else {
			vm.quizOver = true;
			vm.loadingMessage = 'Submitting Answers';
			vm.loading = true;
			console.log(vm.answers);
			var answers = {
				'answers': vm.answers,
			}
			quizService.submitAnswers(answers).then(function(response) {
				vm.answerResults = response;
				vm.loading = false;
			});
		}
	}

	vm.answerQuestion = function(choice) {
		vm.answersDisabled = true;
		var id = vm.questions[vm.currentQuestionIndex].question_id;
		vm.answers[id] = choice.answer_id;
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
		vm.answers = {};
		vm.answerResults = {};
		vm.answersDisabled = false;
	}

	$(document).keydown(function (e) {
	    //console.log(e);
			//console.log(e.originalEvent.key);
			//vm.answerOptions[$index];
			var index = vm.answerOptions.indexOf(e.originalEvent.key);
			if(!vm.answersDisabled && vm.quizStarted && !vm.quizOver && !vm.loading && index >= 0) {
				$scope.$apply(function() {
					var answer = vm.questions[vm.currentQuestionIndex].answers[index];
					vm.answerQuestion(answer);
				});
			}
	});

}
