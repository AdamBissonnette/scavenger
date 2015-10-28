angular.module('scavengerApp', ['ui.router'])

.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

  $urlRouterProvider.otherwise('/clues');

  $stateProvider
  .state('app', {
    abstract: true,
    url: '',
    templateUrl: 'views/Container.php',
    controller: 'navCtrl'
  })
  .state('app.clues', {
    url: '/clues',
    templateUrl: 'views/AddEditClue.php',
    controller: 'clueCtrl'
  })

  .state('app.answers', {
    url: '/answers',
    templateUrl: 'views/AddEditAnswer.php',
    controller: 'answerCtrl'
  })

  .state('app.hints', {
    url: '/hints',
    templateUrl: 'views/AddEditHint.php',
    controller: 'hintCtrl'
  })

  .state('app.stories', {
    url: '/stories',
    templateUrl: 'views/AddEditStory.php',
    controller: 'storyCtrl'
  })

  .state('app.hunts', {
    url: '/hunts',
    templateUrl: 'views/AddEditHunt.php',
    controller: 'huntCtrl'
  })

  .state('app.parties', {
    url: '/parties',
    templateUrl: 'views/AddEditParty.php',
    controller: 'partyCtrl'
  })

  .state('app.clueAssignments', {
    url: '/clues/:clueid/clueAssignments/',
    templateUrl: 'views/AssignmentsClue.php',
    controller: 'clueAssignmentsCtrl',
    params: {clueid: -1, clue: null}
    
    
  })

  .state('app.answerAssignments', {
    url: '/answers/answerAssignments/',
    templateUrl: 'views/AssignmentsAnswer.php',
    controller: 'answerAssignmentsCtrl',
    params: {answerid: -1, answer: null}
  })

  .state('app.log', {
    url: '/log',
    templateUrl: 'views/ViewLog.php',
    controller: 'logCtrl'
  })

  .state('app.map', {
    url: '/map',
    templateUrl: 'views/ViewMap.php',
    controller: 'mapCtrl'
  })

  .state('app.twiMLTests', {
    url: '/TwiMLTests/',
    templateUrl: 'views/TwiMLTests.php',
    controller: 'twiMLTests'
  })

  .state('app.users', {
    url: '/users/',
    templateUrl: 'views/AddEditUser.php',
    controller: 'userCtrl'
  });

}]);