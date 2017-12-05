app.directive('pathToFolder',['$http', function($http) {
  return {
    restrict: 'E',
    templateUrl: '/app/templates/explorer/folder_path.template.html',
    link: function (scope, element, attrs)
    { }
  };
}]);
