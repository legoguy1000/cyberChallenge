angular.module('CyberChallenge')
.service('questionService', function ($http) {
	return {
		getQuestions: function () {
			return $http.get('api/questions')
			.then(function(response) {
				return response.data;
			});
		},
		addQuestion: function (formData) {
			return $http.post('api/questions',formData)
			.then(function(response) {
				return response.data;
			});
		},
		updateQuestion: function (formData) {
			var question_id = formData.question_id != undefined && formData.question_id != null ? formData.question_id:'';
			return $http.put('api/questions/'+question_id,formData)
			.then(function(response) {
				return response.data;
			});
		},
		deleteQuestion: function (question_id) {
			var question_id = question_id != undefined && question_id != null ? question_id:'';
			return $http.delete('api/questions/'+question_id)
			.then(function(response) {
				return response.data;
			});
		},
	};
})
.service('categoryService', function ($http) {
	return {
		getAllCategories: function () {
			return $http.get('api/categories')
			.then(function(response) {
				return response.data;
			});
		},
	};
})
.service('quizService', function ($http) {
	return {
		getQuestions: function (params) {
			return $http.get('api/quiz/questions?'+$.param(params))
			.then(function(response) {
				return response.data;
			});
		},
		submitAnswers: function (formData) {
			return $http.post('api/quiz/answers',formData)
			.then(function(response) {
				return response.data;
			});
		},
	};
});
