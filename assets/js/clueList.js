angular.module('scavengerApp')

.service('ClueListService', function() {
    this.clueList = {};
    this.getList = function() { 
        return this.clueList;
    };
    this.setList = function(list) { this.clueList = list; };
});