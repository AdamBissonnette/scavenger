angular.module('scavengerApp', ['ui.router'])

.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

  $urlRouterProvider.otherwise('/clues');

  $stateProvider

  .state('clues', {
    url: '/clues',
    templateUrl: 'views/AddEditClue.php',
    controller: 'clueCtrl'
  })

  .state('answers', {
    url: '/answers',
    templateUrl: 'views/AddEditAnswer.php',
    controller: 'answerCtrl'
  })

  .state('hints', {
    url: '/hints',
    templateUrl: 'views/AddEditHint.php',
    controller: 'hintCtrl'
  })

  .state('stories', {
    url: '/stories',
    templateUrl: 'views/AddEditStory.php',
    controller: 'storyCtrl'
  })

  .state('clueAssignments', {
    url: '/clues/clueAssignments/',
    templateUrl: 'views/AssignmentsClue.php',
    controller: 'clueAssignmentsCtrl',
    params: {clueid: -1, clue: null}
  })

  .state('answerAssignments', {
    url: '/answers/answerAssignments/',
    templateUrl: 'views/AssignmentsAnswer.php',
    controller: 'answerAssignmentsCtrl',
    params: {answerid: -1, answer: null}
  });

}]);