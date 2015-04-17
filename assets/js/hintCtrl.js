angular.module('scavengerApp')
  .controller('hintCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {
    $scope.loaded = false;
    var list = ListService;

    list.http({fn: "ghints"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          //console.log(response);
          $scope.hintList = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.hintCtrlFormData = {id : "-1", value : "", clue: "-1"};

    $scope.hintCtrlFormData.submit = function(item, event) {
      var data = {fn: "aehint", id : $scope.hintCtrlFormData.id, value : $scope.hintCtrlFormData.value, clue: $scope.hintCtrlFormData.clue}

      list.http(data, 
          function (response) {
            data.id = response.id;
            $scope.hintList[data.id] = data;
          },
          function (response) {
            console.log(response);
          }
        );

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

      list.http(data, 
          function (response) {
            delete $scope.hintList[item.id];
          },
          function (response) {
            console.log(response);
          }
        );
    };

    $scope.changeState = function(stateName) {
      $state.go(stateName);
    };
}]);

