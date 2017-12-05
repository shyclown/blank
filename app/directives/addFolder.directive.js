app.directive('addFolder',['$http', function($http) {
  return {
    restrict: 'E',
    templateUrl: '/app/templates/explorer/folder_add.template.html',
    link: function (scope, element, attrs)
    { }
  };
}]);
