angular.module('scavengerApp', ['ui.router'])

.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

  $urlRouterProvider.otherwise('/');

  $stateProvider

  .state('clue', {
    url: '/',
    templateUrl: 'views/AddEditClue.php',
    controller: 'clueCtrl'
  })

  .state('answer', {
    url: '/answer',
    templateUrl: 'views/AddEditAnswer.php',
    controller: 'answerCtrl'
  })

  // .state('github', {
  //   url: '/github',
  //   templateUrl: 'github//github.html',
  //   controller: 'githubCtrl'
  // });

}]);