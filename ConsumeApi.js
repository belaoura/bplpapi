//GET REQUEST
function list(items, level) {
    for (var key in items) { // iterate
        if (items.hasOwnProperty(key)) {
            // write amount of spaces according to level
            // and write name and newline
            document.write(
                (new Array(level + 1)).join("&nbsp;") +
                key +
                "<br>"
            );

            // if object, call recursively
            if (items[key] != null && typeof items[key] === "object") {
                list(items[key], level + 1);
            }
        }
    }
}
  document.addEventListener('DOMContentLoaded',function(){
  document.getElementById('getMessage').onclick=function(){

       
       var req;
       req=new XMLHttpRequest();
       req.open("GET", 'http://phpapi.test/api/book/read.php',true);
       req.send();
      
       req.onload=function(){
       var json=JSON.parse(req.responseText);

       //limit data called
       // var son =Object.keys(json).filter(function(val) {
       //     return (val.id >= 4);
       // });
           var books =json.books;
          // console.log(books);

         //  console.log( list(books, 5));

      var html = "";
           for (var i = 0; i < books.length; i++) {
               var book = books[i];
               html += "<div class = 'cat'>";
               html += "<strong>" + book.leader + "</strong>: " + book.fields[i] + "<br>";
               html += "</div><br>";

               for (var j = 0; j < book.fields.length; j++) {
                   var tags = books.fields[j];
                   html += "<strong>" + tags['200'] + "</strong>: " + book.fields.length + "<br>";
                   console.log(tags[j]);
               }
           }
      //loop and display data
      // books.forEach(function(val) {
      //     var keys = Object.keys(val);
      //
      //     html += "<div class = 'cat'>";
      //     html += "<strong>" + books.fields + "</strong>: " + val[key] + "<br>";
      //         keys.forEach(function(key) {
      //         html += "<strong>" + key + "</strong>: " + val[key] + "<br>";
      //         });
      //     html += "</div><br>";
      // });

      //append in message class
      document.getElementsByClassName('message')[0].innerHTML=html;         
      };
    };
  });
  
