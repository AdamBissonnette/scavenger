angular.module('scavengerApp')
  .controller('partyCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    $scope.loaded = false;

    var list = ListService;

    list.http({fn: "getEntities", entityName: "Party"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          $scope.partyList = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.partyCtrlFormData = {id : "-1", name : ""};

    $scope.partyCtrlFormData.submit = function(item, event) {
      var data = {fn: "aeparty", id : $scope.partyCtrlFormData.id, name : $scope.partyCtrlFormData.name}

      list.http(data,
          function (response) {
            data.id = response.id;
            $scope.partyList[data.id] = data;
          },
          function(response){
            console.log(response);
          });

      $scope.partyCtrlFormData.reset();
    }

     $scope.partyCtrlFormData.reset = function() {
      $scope.partyCtrlFormData.id = -1;
      $scope.partyCtrlFormData.name = "";
     }

     $scope.editItem = function(item) {
      $scope.partyCtrlFormData.id = item.id;
      $scope.partyCtrlFormData.name = item.name;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'deleteEntity', id : item.id, entityName: "Party"};

      list.http(data,
          function (response) {
            delete $scope.partyList[item.id];
          },
          function(response){
            console.log(response);
          });
    };

    $scope.changeState = function(stateName, item) {
      $state.go(stateName, {"partyid": item.id, "party": item});
    };
}]).filter('orderObjectBy', function(){
 return function(input, attribute) {
    if (!angular.isObject(input)) return input;

    var array = [];
    for(var objectKey in input) {
        array.push(input[objectKey]);
    }

    array.sort(function(a, b){
        a = parseInt(a[attribute]);
        b = parseInt(b[attribute]);
        return a - b;
    });
    return array;
 }
});

