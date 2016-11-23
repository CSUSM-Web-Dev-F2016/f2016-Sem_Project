function loadBeerList() {
    var bodyArray = document.getElementsByClassName("beers");
    for (var i = 0; i < bodyArray.length; i++) {
        bodyArray[i].innerHTML = '<object type="text/html" width="95%" height="400" data="BeerInfo.html" ></object>';
    }
}
