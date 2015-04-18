angular.module('scavengerApp')
.factory('ListService', ["$http", function($http) {
    return {
        list: {},
        getList: function() {
            return this.list;
        },
        setList: function(list) {  if (this.list != "" ) { this.list = list; } else { this.list = {}; } },
        http: function(data, doSuccess, doError) {
            $http({
                method: 'POST',
                url: "callbacks.php",
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
              }).
              success(doSuccess).
              error(doError);
        }
    }
}]);