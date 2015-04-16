angular.module('scavengerApp')
  .controller('clueAssignmentsCtrl', ['$scope', '$rootScope', '$state', '$http', function($scope, $rootScope, $state, ClueListService, $http) {

    $scope.aaloaded = false;
    $scope.taloaded = false;
    $scope.hloaded = false;

    $scope.clueAssignmentCtrlForm = $state.params.clue;

    $scope.changeState = function(stateName) {
      $state.go(stateName);
    };

    if ($scope.clueAssignmentCtrlForm == null)
    {
        $scope.changeState("clues");
    }
    else
    {
        //Get assignments for current clue        
    }

  }]);