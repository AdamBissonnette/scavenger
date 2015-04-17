angular.module('scavengerApp')
  .controller('clueAssignmentsCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    var aaList = ListService;
    var taList = ListService;
    var hList = ListService;

    $scope.aaLoaded = false;
    $scope.taLoaded = false;
    $scope.hLoaded = false;

    $scope.clueAssignmentCtrlForm = $state.params.clue;

    $scope.changeState = function(stateName) {
      $state.go(stateName);
    };

    if ($scope.clueAssignmentCtrlForm == null)
    {
        $scope.changeState("clues");
    }
    else
    {
        //Get assignments for current clue              
        aaList.http({fn: "ganswers"},
          function (response) {
            aaList.setList(response);
            $scope.aaList = aaList.getList();
            $scope.aaLoaded = true;
          },
          function(response){
            console.log(response);
          });

        taList.http({fn: "ganswers"},
          function (response) {
            taList.setList(response);
            $scope.taList = taList.getList();
            $scope.taLoaded = true;
          },
          function(response){
            console.log(response);
          });

        hList.http({fn: "ghints"},
          function (response) {
            hList.setList(response);
            $scope.hList = hList.getList();
            $scope.hLoaded = true;
          },
          function(response){
            console.log(response);
          });
    }

    $scope.assignAA = function(event, item) {
        if (event.target.tagName == "INPUT")
        {
          var data = {fn: "assignAA", clueid: $state.params.clue.id, answerid: item.id}; 

          aaList.http(data, function(response) {console.log("success");}, function(response) {console.log(response);})
          $http({
              method: 'POST',
              url: "callbacks.php",
              data: data,
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(response) {
              //derp
            }).
            error(function(response) {
              console.log(response);
            });
          }
     };

    $scope.assignTA = function(item) {

     };

    $scope.assignH = function(item) {

     };
  }]);