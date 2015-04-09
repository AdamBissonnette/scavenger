angular.module('scavengerApp')
  .controller('clueCtrl', ['$scope', '$rootScope', '$state', 'ClueListService', '$http', function($scope, $rootScope, $state, ClueListService, $http) {

    $http({
        method: 'POST',
        url: "callbacks.php",
        data: {fn : "gclues"},
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        ClueListService.setList(response);
        //console.log(response);
        $scope.clueList = ClueListService.getList();
      }).
      error(function(response) {
        console.log(response);
      });

    $scope.ctrlFormData = {id : "-1", name: "", value : ""};

    $scope.ctrlFormData.submit = function(item, event) {
      var data = {fn: "aeclue", id : $scope.ctrlFormData.id, name: $scope.ctrlFormData.name, value : $scope.ctrlFormData.value}

      $http({
        method: 'POST',
        url: "callbacks.php",
        data: data,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(response) {
        data.id = response.id;
        $scope.clueList[data.id] = data;
        ClueListService.setList($scope.clueList);
      }).
      error(function(response) {
        console.log(response);
      });

      $scope.ctrlFormData.reset();
    }

     $scope.ctrlFormData.reset = function() {
      $scope.ctrlFormData.id = -1;
      $scope.ctrlFormData.name = "";
      $scope.ctrlFormData.value = "";
     }

     $scope.editItem = function(item) {
      $scope.ctrlFormData.id = item.id;
      $scope.ctrlFormData.name = item.name;
      $scope.ctrlFormData.value = item.value;
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
        ClueListService.setList($scope.clueList);
      }).
      error(function(response) {
        console.log(response);
      });
    };
}]);

