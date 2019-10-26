angular.module('CyberChallenge')
.controller('mainController', [
	'$mdSidenav',
	mainController
]);
function mainController($mdSidenav,) {
	var main = this;
	main.toggleItemsList = toggleItemsList;

	function toggleItemsList() {
		$mdSidenav('left').toggle();
	}
}
