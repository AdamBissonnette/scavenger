angular.module('scavengerApp')
  .controller('clueAssignmentsCtrl', ['$scope', '$rootScope', '$state', '$http', function($scope, $rootScope, $state, $http) {

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
            $scope.aaList = response;
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
            $scope.taList = response;
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
            $scope.hList = response;
            $scope.hLoaded = true;
          }).
          error(function(response) {
            console.log(response);
          });
    }

    $scope.assignAA = function(item) {
        var data = {fn: "assignAA", clueid: $state.params.clue.id, answerid: item.id}; 

        $http({
            method: 'POST',
            url: "callbacks.php",
            data: data,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).
          success(function(response) {
            //derp
          }).
          error(function(response) {
            console.log(response);
          });
     };

    $scope.assignTA = function(item) {

     };

    $scope.assignH = function(item) {

     };
  }]);