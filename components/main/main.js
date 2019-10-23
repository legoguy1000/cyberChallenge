angular.module('CyberChallenge')
.controller('mainController', [
	'$rootScope', '$mdSidenav', '$log', '$q', '$state', '$mdToast', '$mdDialog',
	mainController
]);
function mainController($rootScope, $mdSidenav, $log, $q, $state, $mdToast, $mdDialog) {
	var main = this;
	main.toggleItemsList = toggleItemsList;

	function toggleItemsList() {
		$mdSidenav('left').toggle();
	}
}
