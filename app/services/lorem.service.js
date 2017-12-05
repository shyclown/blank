/*
* generates Lorem Ipsum text  
*
*/
app.service('loremIpsum', function($http){

  const self = this;
  let loremIpsumTxt = "";
  let arrayIpsum = [];
  let storage = []; // avoid digest error



  let error = [];

  // request
  const getLoremIpsum = function(){
    $http({
      method: 'GET',
      url: 'loremipsum.txt'
    }).then(
      function(res){
        loremIpsumTxt = res.data; // txt
        arrayIpsum = loremIpsumTxt.split(' ');
      },
      function(res){ error.push(res); });
  };
  // run request
  getLoremIpsum();

  // randomization
  function getRandomArbitrary(min, max) { return Math.floor(Math.random() * (max - min)) + min; }

  this.getSize = function(size, seed = 1)
  {
    if(arrayIpsum.length > 0){

      let pos = parseInt(size+""+seed);

      if(storage[pos]){
        return storage[pos];
      }
      else{
        let arrSize = arrayIpsum.length;
        let maxPick = arrSize - size;
        let startpoint = getRandomArbitrary( 0 , maxPick );
        let endpoint = startpoint + size;
        let smallLorem = arrayIpsum.slice( startpoint, endpoint );
        let str = smallLorem.toString();
        let str_0 = str.replace(/,,/g, "--"); // preserve dash
        let str_1 = str_0.replace(/,/g, " ");
        str = str_1.replace(/--/g, ", ");
        str = str.charAt(0).toUpperCase() + str.slice(1) + "."; // upperCase
        if(str != "."){ storage[pos] = str; }
        return str;
      }
    }
  }

  this.word = function(size, seed = 1){
    let str = self.getSize(size, seed) || 'waiting for content.';
    return str.substring(0, str.length - 1);
  }
});
