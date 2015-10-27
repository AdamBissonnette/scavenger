angular.module('scavengerApp')
  .controller('mapCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {
	    $scope.loaded = false;

	    $scope.changeState = function(stateName, item) {
	      $state.go(stateName);
	    };

		var data = {fn: 'getMap'};
		$.ajax({url: "callbacks.php",
		    data: JSON.stringify(data),
		    processData: false,
		    dataType: "json",
		    method: "POST",
		    success: function(a) {loadCytoscape(a);},
		    error: function (jqXHR, textStatus) {"Request failed: " + textStatus}

		});
	}]);