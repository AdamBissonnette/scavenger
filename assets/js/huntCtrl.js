angular.module('scavengerApp')
  .controller('huntCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {
    $scope.loaded = false;
    var list = ListService;

    $scope.clues = {};
    var cluesList = ListService;
    var storiesList = ListService;
    var partyList = ListService;

    cluesList.http({fn: "getEntities", entityName: "Clue"},
      function (response) {
          cluesList.setList(response);
          $scope.clues = cluesList.getList();
      },
      function(response){
        console.log(response);
      });

    partyList.http({fn: "getEntities", entityName: "Party"},
      function (response) {
          partyList.setList(response);
          $scope.parties = partyList.getList();
      },
      function(response){
        console.log(response);
      });

    storiesList.http({fn: "getEntities", entityName: "Story"},
      function (response) {
          storiesList.setList(response);
          $scope.stories = storiesList.getList();
      },
      function(response){
        console.log(response);
      });

    list.http({fn: "getEntities", entityName: "Hunt"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          //console.log(response);
          $scope.huntList = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.huntCtrlFormData = {id : "-1", start: "", end : "", story: "-1", party: "-1", clue: "-1", hintsUsed: 0};

    $scope.huntCtrlFormData.submit = function(item, event) {
      var data = {fn: "aehunt", id : $scope.huntCtrlFormData.id,
                   start: $scope.huntCtrlFormData.start, 
                   end : $scope.huntCtrlFormData.end,
                   story: $scope.huntCtrlFormData.story,
                   party: $scope.huntCtrlFormData.party,
                   clue: $scope.huntCtrlFormData.clue,
                   hintsUsed: $scope.huntCtrlFormData.hintsUsed}

      list.http(data, 
          function (response) {
            data.id = response.id;
            $scope.huntList[data.id] = data;
          },
          function (response) {
            console.log(response);
          }
        );

      $scope.huntCtrlFormData.reset();
    }

     $scope.huntCtrlFormData.reset = function() {
      $scope.huntCtrlFormData.id = -1;
      $scope.huntCtrlFormData.start = "";
      $scope.huntCtrlFormData.end = "";
      $scope.huntCtrlFormData.story = -1;
      $scope.huntCtrlFormData.party = -1;
      $scope.huntCtrlFormData.clue = -1;
      $scope.huntCtrlFormData.hintsUsed = 0;
     }

     $scope.editItem = function(item) {
      $scope.huntCtrlFormData.id = item.id;
      $scope.huntCtrlFormData.start = item.start;
      $scope.huntCtrlFormData.end = item.end;
      $scope.huntCtrlFormData.story = item.story;
      $scope.huntCtrlFormData.party = item.party;
      $scope.huntCtrlFormData.clue = item.clue;
      $scope.huntCtrlFormData.hintsUsed = item.hintsUsed;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'deleteEntity', id : item.id, entityName: "Hunt"};

      list.http(data, 
          function (response) {
            delete $scope.huntList[item.id];
          },
          function (response) {
            console.log(response);
          }
        );
    };

    $scope.changeState = function(stateName) {
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

