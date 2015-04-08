angular.module('scavengerApp', ['ui.router'])

.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

  $urlRouterProvider.otherwise('/');

  $stateProvider

  .state('clue', {
    url: '/',
    templateUrl: 'views/AddEditClue.php',
    controller: 'clueCtrl'
  })

  // .state('gallery', {
  //   url: '/gallery',
  //   templateUrl: 'gallery/gallery.html',
  //   controller: 'galleryCtrl'
  // })

  // .state('github', {
  //   url: '/github',
  //   templateUrl: 'github//github.html',
  //   controller: 'githubCtrl'
  // });

}]);