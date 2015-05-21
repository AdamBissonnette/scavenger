angular.module('scavengerApp')
  .controller('userCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    $scope.loaded = false;
    $scope.clues = {};

    var list = ListService;
    var cluesList = ListService;

    list.http({fn: "getEntities", entityName: "User"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          $scope.userList = list.getList();
      },
      function(response){
        console.log(response);
      });

    cluesList.http({fn: "getEntities", entityName: "Clue"},
      function (response) {
          cluesList.setList(response);
          $scope.clues = cluesList.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.userCtrlFormData = {id : "-1", name : "", email : "", phone: "", date: "", clueid: -1};

    $scope.userCtrlFormData.submit = function(item, event) {
      var data = {fn: "aeuser", id : $scope.userCtrlFormData.id, name : $scope.userCtrlFormData.name, email : $scope.userCtrlFormData.email, phone: $scope.userCtrlFormData.phone, clueid: $scope.userCtrlFormData.clueid}

      list.http(data,
          function (response) {
            data.id = response.id;
            $scope.userList[data.id] = data;
          },
          function(response){
            console.log(response);
          });

      $scope.userCtrlFormData.reset();
    }

     $scope.userCtrlFormData.reset = function() {
      $scope.userCtrlFormData.id = -1;
      $scope.userCtrlFormData.name = "";
      $scope.userCtrlFormData.email = "";
      $scope.userCtrlFormData.phone = "";
      $scope.userCtrlFormData.date = "";
      $scope.userCtrlFormData.clueid = -1;
     }

     $scope.editItem = function(item) {
      $scope.userCtrlFormData.id = item.id;
      $scope.userCtrlFormData.name = item.name;
      $scope.userCtrlFormData.email = item.email;
      $scope.userCtrlFormData.phone = item.phone;
      $scope.userCtrlFormData.date = item.date;
      $scope.userCtrlFormData.clueid = item.clueid;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'deleteEntity', id : item.id, entityName: "User"};

      list.http(data,
          function (response) {
            delete $scope.userList[item.id];
          },
          function(response){
            console.log(response);
          });
    };

    $scope.changeState = function(stateName, item) {
      $state.go(stateName, {"userid": item.id, "user": item});
    };
}]);

