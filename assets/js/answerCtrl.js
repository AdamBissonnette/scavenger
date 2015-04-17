angular.module('scavengerApp')
  .controller('answerCtrl', ['$scope', '$rootScope', '$state', '$http', function($scope, $rootScope, $state, $http) {

    $scope.loaded = false;

    $http({
        method: 'POST',
        url: "callbacks.php",
        data: {fn : "ganswers"},
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        $scope.answerList = response;
        $scope.loaded = true;
      }).
      error(function(response) {
        console.log(response);
      });

    $scope.answerCtrlFormData = {id : "-1", value : "", nextClue: "-1"};

    $scope.answerCtrlFormData.submit = function(item, event) {
      var data = {fn: "aeanswer", id : $scope.answerCtrlFormData.id, value : $scope.answerCtrlFormData.value, nextClue: $scope.answerCtrlFormData.nextClue}

      $http({
        method: 'POST',
        url: "callbacks.php",
        data: data,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        data.id = response.id;
        $scope.answerList[data.id] = data;
      }).
      error(function(response) {
        console.log(response);
      });

      $scope.answerCtrlFormData.reset();
    }

     $scope.answerCtrlFormData.reset = function() {
      $scope.answerCtrlFormData.id = -1;
      $scope.answerCtrlFormData.value = "";
      // $scope.answerCtrlFormData.nextClue = -1;
     }

     $scope.editItem = function(item) {
      $scope.answerCtrlFormData.id = item.id;
      // $scope.answerCtrlFormData.nextClue = item.nextClue;
      $scope.answerCtrlFormData.value = item.value;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'delanswer', id : item.id};

      $http({
        method: 'POST',
        url: "callbacks.php",
        data: data,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        delete $scope.answerList[item.id];
      }).
      error(function(response) {
        console.log(response);
      });
    };

    $scope.changeState = function(stateName) {
      $state.go(stateName);
    };
}]);

