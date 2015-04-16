angular.module('scavengerApp')

.service('ListService', function() {
    this.List = {};
    this.getList = function() { 
        return this.List;
    };
    this.setList = function(list) {  if (list != null ) { this.List = list; } else { this.List = {}; } };
});