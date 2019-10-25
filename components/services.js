angular.module('CyberChallenge')
.service('questionService', function ($http) {
	return {
		getQuestions: function (params) {
			return $http.get('api/questions?'+$.param(params))
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
});