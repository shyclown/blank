app.controller('mainController',function($http, $scope, $route, $routeParams, $location, directiveLoader){

  /* Route Info */
  $scope.$route = $route;
  $scope.$location = $location;
  $scope.$routeParams = $routeParams;

  $scope.$watch(function(){
    return $location.path();
  }, function(value){
    $scope.url = value;
  });

  new directiveLoader.directiveElement('edit-file-window', {}, function(){}, $scope);



});
