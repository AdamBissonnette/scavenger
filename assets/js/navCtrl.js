angular.module('scavengerApp')
  .controller('navCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    var storyList = ListService;

    storyList.http({fn: "getEntities", entityName: "Story"},
      function (response) {
          storyList.setList(response);
          $rootScope.navStories = storyList.getList();
      },
      function(response){
        console.log(response);
      });

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