angular.module('scavengerApp')
  .controller('mapCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

		loadMap();

		$scope.loadMap = function () {
			loadMap();
		}
	}]);