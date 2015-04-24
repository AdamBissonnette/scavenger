angular.module('scavengerApp')
  .controller('twiMLTests', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {




    $scope.changeState = function(stateName, item) {
      $state.go(stateName);
    };
}]);