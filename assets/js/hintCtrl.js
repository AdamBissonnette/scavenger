angular.module('scavengerApp')
  .controller('hintCtrl', ['$scope', '$rootScope', '$state', 'HintListService', '$http', function($scope, $rootScope, $state, HintListService, $http) {
    $scope.loaded = false;

    $http({
        method: 'POST',
        url: "callbacks.php",
        data: {fn : "ghints"},
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        HintListService.setList(response);
        $scope.loaded = true;
        //console.log(response);
        $scope.hintList = HintListService.getList();
      }).
      error(function(response) {
        console.log(response);
      });

    $scope.hintCtrlFormData = {id : "-1", value : "", clue: "-1"};

    $scope.hintCtrlFormData.submit = function(item, event) {
      var data = {fn: "aehint", id : $scope.hintCtrlFormData.id, value : $scope.hintCtrlFormData.value, clue: $scope.hintCtrlFormData.clue}

      $http({
        method: 'POST',
        url: "callbacks.php",
        data: data,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        data.id = response.id;
        $scope.hintList[data.id] = data;
        HintListService.setList($scope.hintList);
      }).
      error(function(response) {
        console.log(response);
      });

      $scope.hintCtrlFormData.reset();
    }

     $scope.hintCtrlFormData.reset = function() {
      $scope.hintCtrlFormData.id = -1;
      $scope.hintCtrlFormData.value = "";
      // $scope.hintCtrlFormData.clue = -1;
     }

     $scope.editItem = function(item) {
      $scope.hintCtrlFormData.id = item.id;
      // $scope.hintCtrlFormData.clue = item.clue;
      $scope.hintCtrlFormData.value = item.value;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'delhint', id : item.id};

      $http({
        method: 'POST',
        url: "callbacks.php",
        data: data,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        delete $scope.hintList[item.id];
        HintListService.setList($scope.hintList);
      }).
      error(function(response) {
        console.log(response);
      });
    };

    $scope.changeState = function(stateName) {
      $state.go(stateName);
    };
}]);

