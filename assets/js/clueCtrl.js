angular.module('scavengerApp')
  .controller('clueCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    var list = ListService;
    $scope.loaded = false;

    list.http({fn: "getEntities", entityName: "Clue"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          //console.log(response);
          $scope.clueList = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.clueCtrlFormData = {id : "-1", name: "", value : ""};

    $scope.clueCtrlFormData.submit = function(item, event) {
      var data = {fn: "aeclue", id : $scope.clueCtrlFormData.id, name: $scope.clueCtrlFormData.name, value : $scope.clueCtrlFormData.value}
      list.http(data,
        function(response) {
        data.id = response.id;
        $scope.clueList[data.id] = data;
        list.setList($scope.clueList);
      },
      function(response) {
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
      var data = {fn: 'deleteEntityt', id : item.id, entityName: "Clue"};

      list.http(data,
        function(response) {
        delete $scope.clueList[item.id];
        list.setList($scope.clueList);
      },
      function(response) {
        console.log(response);
      });
      $scope.clueCtrlFormData.reset();
    };

    $scope.changeState = function(stateName, item) {
      $state.go(stateName, {"clueid": item.id, "clue": item});
    };
}]);

