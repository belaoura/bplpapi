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

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('getMessage').onclick = function () {

        var req;
        req = new XMLHttpRequest();
        req.open("GET", 'http://phpapi.test/api/book/read.php', true);
        req.send();

        req.onload = function () {
            var json = JSON.parse(req.responseText);

            var books = json.books;
            console.log(books[0]["fields"]);
            console.log(books[0]["fields"][0]);
            console.log(books[0]["fields"][4]["200"]);
            console.log(books[0]["fields"][4]["200"].subfields["0"]);
            console.log(books[0]["fields"][4]["200"].subfields["0"].$a);
            console.log(books[0]["fields"][4]["200"].subfields["1"].$d);

            var html = "";
            for (var i = 0; i < books.length; i++) {
                // console.log(books[i]["fields"][4]["200"].subfields["0"].$a);
                var book = books[i];
                html += "<div class='card col-md-12 mb-2' >";
                html += "<div class='card-body'>";
                html += "<h4><strong> <span class='badge badge-info'>ISBN :</span> " +books[i]["fields"][0]["010"].subfields["0"].$a+ "</strong></h4><br>";
                html += "<div class='row'> <div class='col'>";
                html += " <input class='form-control form-control-sm' type='text' value='" + books[i]["fields"][4]["200"].subfields["0"].$a + "'> <br>";
                html += " <input class='form-control form-control-sm'  type='text' value='" + books[i]["fields"][5]["210"].subfields["1"].$c + "'> <br>";
                html += " <input class='form-control form-control-sm'  type='text' value='" + books[i]["fields"][5]["210"].subfields["0"].$a + "'> <br>";
                html += " <input class='form-control form-control-sm'  type='text' value='" + books[i]["fields"][5]["210"].subfields["2"].$d + "'> <br>";
                html += "</div> <div class='col'>";
                html += " <input class='form-control form-control-sm' type='text' value='" + books[i]["fields"][4]["200"].subfields["1"].$d + "'> <br>";
                html += " <input class='form-control form-control-sm'  type='text' value='" + books[i]["fields"][7]["215"].subfields["0"].$a + "'> <br>";
                html += " <input class='form-control form-control-sm'  type='text' value='" + books[i]["fields"][7]["215"].subfields["1"].$d + "'> <br>";
                html += " <input class='form-control form-control-sm'  type='text' value='" + books[i]["fields"][7]["215"].subfields["2"].$c + "'> <br>";
                html += "</div> </div>";
                html += "</div>";
                html += "</div>";
            }


            //append in message class
            document.getElementsByClassName('message')[0].innerHTML = html;
        };
    };
});
  
