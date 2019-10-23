angular.module('CyberChallenge', [
	'ngSanitize',
	'ui.router',
	'ngMaterial',
]).config(function ($stateProvider, $urlRouterProvider, $mdThemingProvider, $mdIconProvider, $locationProvider) {

	$locationProvider.html5Mode({ enabled: true, requireBase: true });
	$stateProvider
	  .state('main', {
		url: '',
		templateUrl: 'components/main/main.html',
		controller: 'mainController',
		controllerAs: 'main',
		abstract: true,
	  })
	  .state('main.home', {
		url: '/home',
		templateUrl: 'components/main.home/main.home.html',
		controller: 'main.homeController',
		controllerAs: 'vm',
	}); /*
	  .state('main.signin', {
		url: '/signin',
		templateUrl: 'views/main.signin.html',
		controller: 'main.signinController',
		controllerAs: 'vm',
	  })
	  .state('main.admin', {
		url: '/admin',
		templateUrl: 'views/main.admin.html',
		controller: 'main.adminController',
		controllerAs: 'admin',
		abstract: true,
		authenticate: true,
		admin: true,
		default: 'main.admin.users',
		data: {
		  title: 'Admin'
		},
	  resolve: { // Any property in resolve should return a promise and is executed before the view is loaded
	    adminController: ['$ocLazyLoad', function($ocLazyLoad) {
	      // you can lazy load files for an existing module
	             return $ocLazyLoad.load('js/controllers/main.adminController.js');
	    }]
	  }
	}) */
	$urlRouterProvider.otherwise('/home');
})
.config( ['$compileProvider', function( $compileProvider ) {
        $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|slack):/);
        // Angular before v1.2 uses $compileProvider.urlSanitizationWhitelist(...)
}]);
