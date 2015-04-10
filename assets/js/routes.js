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
  });

}]);