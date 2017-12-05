app.directive('isDropArea',['$http',function($http) {
  return {
    restrict: 'A',
    scope: { onDropFn: '=isDropArea' },
    link: function (scope, element, attrs)
    {
      //const onDropFn = scope.$eval(attrs.isDropArea);
      const stopDefault = function(){
        event.stopPropagation();
        event.preventDefault();
      }
      element.bind('dragover',  stopDefault );
      element.bind('dragenter', stopDefault );
      element.bind('dragleave', stopDefault );
      element.bind('drop', function(event)
      {
        stopDefault(event);
        scope.onDropFn(event);
      });
    }
  };
}]);
