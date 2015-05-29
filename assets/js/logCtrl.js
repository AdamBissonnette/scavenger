angular.module('scavengerApp')
  .controller('logCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    $scope.loaded = false;
    var list = ListService;

    list.http({fn: "getEntities", entityName: "Log"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          $scope.list = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.deleteItem = function(item) {
      var data = {fn: 'deleteEntity', id : item.id, entityName: "Log"};

      list.http(data,
          function (response) {
            delete $scope.list[item.id];
          },
          function(response){
            console.log(response);
          });
    };

    $scope.changeState = function(stateName, item) {
      $state.go(stateName);
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