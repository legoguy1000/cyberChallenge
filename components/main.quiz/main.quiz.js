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
	vm.quizSet = false;
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
		'categories': [],
		'difficulty': [],
		'count': 5,
		'time': 15,
	};

	vm.getQuiz = function() {
		quizService.getQuiz().then(function(response) {
			if(response != null && response != undefined) {
				vm.quizSet = true;
				vm.quizParams = {
					'categories': response.categories,
					'difficulty': response.difficulty,
					'count': response.question_count,
					'time': response.time,
				};
			}
		});
	}
	vm.getQuiz();

	function getAllCategories() {
		categoryService.getAllCategories().then(function(response) {
			vm.categories = response;
			/* angular.forEach(vm.categories, function(value, key) {
				vm.quizParams.categories.push(value.category_id);
			}); */
		});
	}
	getAllCategories();


	vm.startQuiz = 	function() {
		vm.loadingMessage = 'Getting Questions';
		vm.loading = true;
		vm.startOver();
		vm.timer = vm.quizParams.time;
		//vm.quizOver = false;
		//vm.answersDisabled = false;
		//vm.answerResults = {};
		//vm.answers = {};
		//vm.currentQuestionIndex = 0;
		//vm.questions = [];
		var params = {
			'categories': vm.quizParams.categories,
			'count': vm.quizParams.count,
			'difficulty': vm.quizParams.difficulty,
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
			if(!vm.loading && e.originalEvent.key=='a') {
				$scope.$apply(function() {
					if(!vm.quizStarted || (vm.quizStarted && vm.quizOver && vm.quizSet)) {
						vm.startQuiz();
					} else if (vm.quizStarted && vm.quizOver) {
						vm.startOver();
					}
				});
			}
	});

}
