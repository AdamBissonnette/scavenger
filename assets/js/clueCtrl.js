angular.module('scavengerApp')
  .controller('clueCtrl', ['$scope', '$rootScope', '$state', 'ListService', '$http', function($scope, $rootScope, $state, ListService, $http) {

    $scope.loaded = false;

    $http({
        method: 'POST',
        url: "callbacks.php",
        data: {fn : "gclues"},
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        ListService.setList(response);
        $scope.loaded = true;
        //console.log(response);
        $scope.clueList = ListService.getList();
      }).
      error(function(response) {
        console.log(response);
      });

    $scope.clueCtrlFormData = {id : "-1", name: "", value : ""};

    $scope.clueCtrlFormData.submit = function(item, event) {
      var data = {fn: "aeclue", id : $scope.clueCtrlFormData.id, name: $scope.clueCtrlFormData.name, value : $scope.clueCtrlFormData.value}

      $http({
        method: 'POST',
        url: "callbacks.php",
        data: data,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        data.id = response.id;
        $scope.clueList[data.id] = data;
        ListService.setList($scope.clueList);
      }).
      error(function(response) {
        console.log(response);
      });

      $scope.clueCtrlFormData.reset();
    }

     $scope.clueCtrlFormData.reset = function() {
      $scope.clueCtrlFormData.id = -1;
      $scope.clueCtrlFormData.name = "";
      $scope.clueCtrlFormData.value = "";
     }

     $scope.editItem = function(item) {
      $scope.clueCtrlFormData.id = item.id;
      $scope.clueCtrlFormData.name = item.name;
      $scope.clueCtrlFormData.value = item.value;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'delclue', id : item.id};

      $http({
        method: 'POST',
        url: "callbacks.php",
        data: data,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        delete $scope.clueList[item.id];
        ListService.setList($scope.clueList);
      }).
      error(function(response) {
        console.log(response);
      });
    };

    $scope.changeState = function(stateName, item) {
      $state.go(stateName, {"clue": item});
    };
}]);

