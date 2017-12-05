app.directive('explorer',['directiveLoader', 'Folder', 'Article', 'Shared',
function( directiveLoader, Folder, Article, Shared ) {
  return {
    restrict: 'E',
    scope:{},
    templateUrl: '/app/templates/explorer.template.html',
    link: function (scope, element, attrs)
    {
      // Load Exploerer Element
      scope.explorerWindow = directiveLoader.openElement[attrs.editObj];
      // Setup Cancel Function
      scope.cancel = function(){  scope.explorerWindow.close();  }
      // Open Data from Loader
      scope.openExplorer = scope.explorerWindow.item;

      // Load Folders
      scope.$watch(
        function(){ return Folder.allFolders; },
        function(){ scope.folders = Folder.allFolders; console.log(scope.folders);},
      true);
      let updateScope = function(){ scope.$apply(); console.log(scope.folders);};
      Folder.select_all(updateScope);

      // Explorer
      const explorer = Shared.explorer;
      explorer.current_folder = null;
      scope.currentFolder = null;
      scope.currentParents = [];
      scope.openFoldersInTree = [];

      // Watch
      scope.$watch( function(){ return explorer.articles; }, function(){ scope.articles = explorer.articles; }, true);

      // New FOLDER

      scope.new_folder = {  };
      scope.saveNewFolder = function(){
        let data = scope.new_folder;
        data.parent = scope.currentFolder;
        Folder.insert( data, function(response){
          scope.new_folder.name = "";
          scope.$apply();
        });
      }


      // OPEN FOLDER
      scope.isOpenFolder = function(){ return scope.currentFolder != null; }
      scope.openFolder = function(folder){
      // prompted action
      const inFolderArray = function(id){
        let pos = scope.openFoldersInTree.indexOf(id); return { open: pos >= 0, position: pos };
      }
      if(folder == null){ scope.currentFolder = folder;  Shared.explorer.current_folder = folder; }
      else{
        const folderInArray = inFolderArray(folder.id);
        const folderIsCurrent = folder == scope.currentFolder;

        if(!folderIsCurrent){
          Shared.explorer.current_folder = folder;
          scope.currentFolder = folder;
          scope.currentParents = Folder.listParents(folder);
        }
        if(folderInArray.open && folderIsCurrent){
          scope.openFoldersInTree.splice(folderInArray.position, 1);
        }
        if(!folderInArray.open){
          scope.openFoldersInTree.push(folder.id);
        }
      }

    }
    scope.isOpen = function(folder){ return folder.id == scope.currentFolder.id; }

  }//link
  }//return
  }//directivefunction
]);
