angular.module('scavengerApp')

.service('ClueListService', ['$http', function($http) {
    this.clueList = {};
    this.getList = function() { 
        return this.clueList;
    };
    this.setList = function(list) { this.clueList = list; };
}]);