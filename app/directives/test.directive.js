app.directive('editFileWindow',['directiveLoader',
function( directiveLoader ) {
  return {
    restrict: 'E',
    scope:{},
    templateUrl: '/app/templates/edit_file_window.html',
    link: function (scope, element, attrs)
    {
      scope.fileWindow = directiveLoader.openElement[attrs.editObj];
      scope.cancel = function(){  scope.fileWindow.close();  }
      scope.openFile = scope.fileWindow.item;



  }//link
  }//return
  }//directivefunction
]);
