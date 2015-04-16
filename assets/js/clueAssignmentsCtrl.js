angular.module('scavengerApp')
  .controller('clueAssignmentsCtrl', ['$scope', '$rootScope', '$state', 'ListService', '$http', function($scope, $rootScope, $state, ListService, $http) {

    $scope.aaLoaded = false;
    $scope.taLoaded = false;
    $scope.hLoaded = false;

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
        $http({
            method: 'POST',
            url: "callbacks.php",
            data: {fn : "ganswers"},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).
          success(function(response) {
            ListService.setList(response);
            $scope.aaList = ListService.getList();
            $scope.aaLoaded = true;
          }).
          error(function(response) {
            console.log(response);
          });

          $http({
            method: 'POST',
            url: "callbacks.php",
            data: {fn : "ganswers"},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).
          success(function(response) {
            ListService.setList(response);
            $scope.taList = ListService.getList();
            $scope.taLoaded = true;
          }).
          error(function(response) {
            console.log(response);
          });

          $http({
            method: 'POST',
            url: "callbacks.php",
            data: {fn : "ghints"},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).
          success(function(response) {
            ListService.setList(response);
            $scope.hList = ListService.getList();
            $scope.hLoaded = true;
          }).
          error(function(response) {
            console.log(response);
          });
    }
  }]);