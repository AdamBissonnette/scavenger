angular.$externalBroadcast = function (selector, event, message) {
    var scope = angular.element(selector).scope();

    scope.$apply(function () {
        scope.$broadcast(event, message);
    });
};

angular.module('scavengerApp')
  .controller('mapCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {
	    $scope.loaded = false;

	    //List Services
	    $scope.clueList = {};
	    $scope.answerList = {};
	    $scope.hintList = {};

	    var cluesList = ListService;
	    var answersList = ListService;
	    var hintsList = ListService;

	    cluesList.http({fn: "getEntities", entityName: "Clue"},
	      function (response) {
	          cluesList.setList(response);
	          $scope.loaded = true;
	          //console.log(response);
	          $scope.clueList = cluesList.getList();
	      },
	      function(response){
	        console.log(response);
	      });

	    answersList.http({fn: "getEntities", entityName: "Answer"},
	      function (response) {
	          answersList.setList(response);
	          $scope.loaded = true;
	          //console.log(response);
	          $scope.answerList = answersList.getList();
	      },
	      function(response){
	        console.log(response);
	      });

	    hintsList.http({fn: "getEntities", entityName: "Answer"},
	      function (response) {
	          hintsList.setList(response);
	          $scope.loaded = true;
	          //console.log(response);
	          $scope.hintList = hintsList.getList();
	      },
	      function(response){
	        console.log(response);
	      });

	    //Answer Control Forms
	    $scope.answerCtrlFormData = {id : "-1", name : "", value : "", clueid: "-1", storyid: "-1"};

	    $scope.answerCtrlFormData.submit = function(item, event) {
	      var data = {fn: "aeanswer", id : $scope.answerCtrlFormData.id, name : $scope.answerCtrlFormData.name, value : $scope.answerCtrlFormData.value, clueid: $scope.answerCtrlFormData.clueid, storyid : $scope.answerCtrlFormData.storyid}

	      answersList.http(data,
	          function (response) {
	            data.id = response.id;
	            $scope.answerList[data.id] = data;
	          },
	          function(response){
	            console.log(response);
	          });

	      $scope.answerCtrlFormData.reset();
	    }

	     $scope.answerCtrlFormData.reset = function() {
	      $scope.answerCtrlFormData.id = -1;
	      $scope.answerCtrlFormData.name = "";
	      $scope.answerCtrlFormData.value = "";
	      $scope.answerCtrlFormData.clueid = -1;
	     }

	     $scope.answerCtrlFormData.editItem = function(item) {
	      $scope.answerCtrlFormData.id = item.id;
	      $scope.answerCtrlFormData.name = item.name;
	      $scope.answerCtrlFormData.clueid = item.clueid;
	      $scope.answerCtrlFormData.value = item.value;
	      $scope.answerCtrlFormData.storyid = item.storyid;
	     }

	    $scope.answerCtrlFormData.deleteItem = function(item) {
	      var data = {fn: 'deleteEntity', id : item.id, entityName: "Answer"};

	      answersList.http(data,
	          function (response) {
	            delete $scope.answerList[item.id];
	            map.remove(map.$('#a' + item.id));
	          },
	          function(response){
	            console.log(response);
	          });
	    };

	    //Clue Control Forms
	    $scope.clueCtrlFormData = {id : "-1", name: "", value : "", storyid : "-1"};

	    $scope.clueCtrlFormData.submit = function(item, event) {
	      var navstoryid = -1;
	      if (typeof $scope.nav !== "undefined")
	      {
	        navstoryid = $scope.nav.storyid;
	      }
	      var data = {fn: "aeclue", id : $scope.clueCtrlFormData.id, name: $scope.clueCtrlFormData.name, value : $scope.clueCtrlFormData.value, storyid : $scope.clueCtrlFormData.storyid}
	      cluesList.http(data,
	        function(response) {

        	if (data.id == -1)
        	{
        		//add new element to the map
        		map.add({group: "nodes", data: {id: 'c' + response.id, label: response.id + '-' + data.name, item: response.id, weight: 5}, position: {x: 200, y: 100}});
        		addQTip('c' + response.id);
        	}
        	else
        	{
        		map.$('#c' + response.id).style("content", response.id + '-' + data.name);
        	}

	        data.id = response.id;
	        $scope.clueList[data.id] = data;
	        cluesList.setList($scope.clueList);
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

	     $scope.clueCtrlFormData.editItem = function(item) {
	      $scope.clueCtrlFormData.id = item.id;
	      $scope.clueCtrlFormData.name = item.name;
	      $scope.clueCtrlFormData.value = item.value;
	      $scope.clueCtrlFormData.storyid = item.storyid;
	     }

	    $scope.clueCtrlFormData.deleteItem = function(item) {
	      var data = {fn: 'deleteEntity', id : item.id, entityName: "Clue"};

	      cluesList.http(data,
	        function(response) {
	        delete $scope.clueList[item.id];
	        cluesList.setList($scope.clueList);
	        map.remove(map.$('#c' + item.id));
	      },
	      function(response) {
	        console.log(response);
	      });
	      $scope.clueCtrlFormData.reset();
	    };

	    //Hint Control Forms
	    $scope.hintCtrlFormData = {id : "-1", name: "", value : "", clue: "-1", priority: "5", storyid: "-1"};

	    $scope.hintCtrlFormData.submit = function(item, event) {
	      var data = {fn: "aehint", id : $scope.hintCtrlFormData.id, name: $scope.hintCtrlFormData.name, value : $scope.hintCtrlFormData.value, clue: $scope.hintCtrlFormData.clue, priority: $scope.hintCtrlFormData.priority, storyid : $scope.hintCtrlFormData.storyid}

	      hintsList.http(data, 
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
	      $scope.hintCtrlFormData.name = "";
	      $scope.hintCtrlFormData.value = "";
	      $scope.hintCtrlFormData.clue = -1;
	      $scope.hintCtrlFormData.priority = 5;
	     }

	     $scope.hintCtrlFormData.editItem = function(item) {
	      $scope.hintCtrlFormData.id = item.id;
	      $scope.hintCtrlFormData.name = item.name;
	      $scope.hintCtrlFormData.value = item.value;
	      $scope.hintCtrlFormData.clue = item.clue;
	      $scope.hintCtrlFormData.priority = item.priority;
	      $scope.hintCtrlFormData.storyid = item.storyid;
	     }

	    $scope.hintCtrlFormData.deleteItem = function(item) {
	      var data = {fn: 'deleteEntity', id : item.id, entityName: "Hint"};

	      hintsList.http(data, 
	          function (response) {
	            delete $scope.hintList[item.id];
	            map.remove(map.$('#h' + item.id));
	          },
	          function (response) {
	            console.log(response);
	          }
	        );
	    };

	    $scope.clueCtrlFormData.changeState = function(stateName, item) {
	      $state.go(stateName, {"clueid": item.id, "clue": item});
	    };

	    $scope.answerCtrlFormData.changeState = function(stateName, item) {
	      $state.go(stateName, {"answerid": item.id, "answer": item});
	    };

	    $scope.changeState = function(stateName, item) {
	      $state.go(stateName);
	    };

		loadMap();

		$scope.loadMap = function () {
			loadMap();
		}

		$rootScope.$on('editClue', function(clue) {
			$scope.clueCtrlFormData.editClue(clue);
		});
	}]);