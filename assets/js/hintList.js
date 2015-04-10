angular.module('scavengerApp')

.service('HintListService', function() {
    this.hintList = {};
    this.getList = function() { 
        return this.hintList;
    };
    this.setList = function(list) { this.hintList = list; };
});