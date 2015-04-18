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
        aaList.http({fn: "ganswers", clueid: $state.params.clue.id},
          function (response) {
            angular.forEach($scope.clueAssignmentCtrlForm.answers, function(answer) {
              angular.forEach(response, function (item) {
                if(answer.id == item.id)
                  item.checked = true;
                });
            });

            aaList.setList(response);
            $scope.aaList = aaList.getList();
            $scope.aaLoaded = true;
            console.log(response);
          },
          function(response){
            console.log(response);
          });

        taList.http({fn: "ganswers"},
          function (response) {
            angular.forEach($scope.clueAssignmentCtrlForm.acceptedAnswers, function(answer) {
              angular.forEach(response, function (item) {
                if(answer.id == item.id)
                  item.checked = true;
                });
            });

            taList.setList(response);
            $scope.taList = taList.getList();
            $scope.taLoaded = true;
          },
          function(response){
            console.log(response);
          });

        hList.http({fn: "ghints"},
          function (response) {
            angular.forEach($scope.clueAssignmentCtrlForm.hints, function(answer) {
              angular.forEach(response, function (item) {
                if(answer.id == item.id)
                  item.checked = true;
                });
            });

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
          var data = {fn: "assignAcceptableAnswer", clueid: $state.params.clue.id, answerid: item.id, checked: item.checked};
          console.log(data);
          aaList.http(data, function(response) {
            //console.log("success");
          }, function(response) {console.log(response);});
        }
     };

    $scope.assignTA = function(event, item) {
      if (event.target.tagName == "INPUT")
      {
        var data = {fn: "assignNextClue", clueid: $state.params.clue.id, answerid: item.id, checked: item.checked};
        taList.http(data, function(response) {
          //console.log("success");
        }, function(response) {console.log(response);});
      }
     };

    $scope.assignH = function(event, item) {
      if (event.target.tagName == "INPUT")
      {
        var data = {fn: "assignHint", clueid: $state.params.clue.id, answerid: item.id, checked: item.checked};
        console.log(data);
        hList.http(data, function(response) {
          //console.log("success");
        }, function(response) {console.log(response);});
      }
     };
  }]);