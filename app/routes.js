app.config(function($routeProvider, $locationProvider){
  $routeProvider.when('/home', {
      templateUrl: '/pages/home.php',
      //controller: 'MainController'
  })
  .when('/programming', {
      templateUrl: '/pages/programming.php',
      //controller: 'pagesController'
  })
  .when('/illustration', {
      templateUrl: '/pages/illustration.php',
      //controller: 'pagesController'
  })
  .when('/architecture', {
      templateUrl: '/pages/architecture.php',
      //controller: 'pagesController'
  })
  .when('/photos', {
      templateUrl: '/pages/photos.php',
      //controller: 'pagesController'
  })
  .otherwise({ redirectTo: '/photos' });
  $locationProvider.html5Mode(true).hashPrefix('!');
});
