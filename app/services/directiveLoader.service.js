// elements are placed to body element

app.service('directiveLoader',function($document, $compile){

const self = this;
this.storage = {};

let windowID = 0;
this.openElement = [];


  const directiveOBJ = function(name, generatedID, item, callback, scope){
    this.html = '<'+name+' edit-obj="'+generatedID+'"></'+name+'>';
    this.el = $compile( this.html )( scope );
    this.item = item;
    this.callback = callback;
    this.close = function(){

      this.el.remove();
    };
  }

  // returns directiveOBJ object
  this.directiveElement = function( name, item, callback, scope )
  {
      callback = callback || function(){};
      item = item || false;
      const generatedID = 'item_'+windowID;
      self.openElement[generatedID] = new directiveOBJ(name, generatedID, item, callback, scope);
      angular.element($document).find('body').append(self.openElement[generatedID].el);
      windowID++;
      return self.openElement[generatedID];
  }


});
