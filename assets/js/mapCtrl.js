angular.module('scavengerApp')
  .controller('mapCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {
	    $scope.loaded = false;

	    $scope.changeState = function(stateName, item) {
	      $state.go(stateName);
	    };

		loadMap();

		$scope.loadMap = function () {
			loadMap();
		}
	}]);