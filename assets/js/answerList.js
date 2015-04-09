angular.module('scavengerApp')

.service('AnswerListService', function() {
    this.answerList = {};
    this.getList = function() { 
        return this.answerList;
    };
    this.setList = function(list) { this.answerList = list; };
});