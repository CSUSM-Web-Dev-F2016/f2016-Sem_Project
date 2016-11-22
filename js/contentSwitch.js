/**
 * File is going to be used for swutching out the src of the content's iframe
 */

function showSRC(address) {

    //window.alert("Hello world");

    //Get the section's DOM element
    var sectionDOM = document.getElementById("contentFrame");

    //Now, set the source of the DOM
    sectionDOM.src = "../html/" + address;

    sectionDOM.style.width = "100%";

}

function logout() {
    //This wil direct the user to a temp page, whiich will reset all session vars and bring the user to the login
    //Screen again so that they need to login to continue.

    window.location.href = "../php/resetUser.php";
}

function showBeerView(beerID) {
    //Get the section's DOM element
    var sectionDOM = document.getElementById("contentFrame");

    //Set the new page
    sectionDOM.src = "../html/" + "BeerInfo.php?beerID=" + beerID;

    sectionDOM.style.width = "100%";
}

function startSearch() {
    //Get the section's DOM element
    var sectionDOM = document.getElementById("contentFrame");

    var inputText = document.getElementsByTagName("form")[0].getElementsByTagName("input")[0].value;

    if (inputText.length > 0) {
        //Set the new page
        sectionDOM.src = "../php/searchResults.php?text=" + inputText;
        sectionDOM.style.width = "100%";
    } else {
        //Show the news feed
        sectionDOM.src = "../html/NewsFeed.html";
        sectionDOM.style.width = "100%";
    }

}

/**
 * Will eventually redirect to the homepage then open the iframe page address provided
 */
function goHomeAnd(address) {

    // window.alert("Hello World 2");

    //Navigate to the home page
    window.location.href = "../html/profilePage.php";

    //Show the requested source after the page loaded
    //showSRC(address);
}


/**
 * Used to resize the iFrame based on the content
 */
function resizeIframe(obj) {
    //Reset the frame height after every load
    obj.style.height = 0;

    //Set the new height of the frame
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';


}


function buildPNF(address) {
    document.getElementById("MainArea").innerHTML = "";
    var mainElement = document.createElement("div");
    mainElement.className = "FNFContainer";

    var subDiv = document.createElement("div");
    mainElement.className = "stdSection";



    var mainHeader = document.createElement("h1");
    mainHeader.className = "PNFTitle";
    mainHeader.innerHTML = "Page Not Found";


    var line = document.createElement("hr");

    var mainImageDiv = document.createElement("div");
    var mainImage = document.createElement("img");
    mainImage.className = "largeImageForPNF";
    mainImage.src = "https://github.com/CSUSM-Web-Dev-F2016/f2016-Sem_Project/blob/master/Final%20Version/BeerHopperLogo.png?raw=true";
    mainImage.alt = "Beer Hopper Logo";


    var subText = document.createElement("div");
    subText.className = "PNFDescription"
    subText.innerHTML = "No page has been created for " + address + " yet. Please try another."


    subDiv.appendChild(mainHeader);
    subDiv.appendChild(mainImageDiv);
    subDiv.appendChild(mainImage);
    subDiv.appendChild(subText);

    mainElement.appendChild(subDiv);

    document.getElementById("MainArea").appendChild(mainElement);
    return;

}

function changeToBrewery(breweryID) {
    //Set the current brewery ID
    sessionStorage['breweryID'] = breweryID;

    window.alert("Got it: " + breweryID);

    //Change the current page location
    window.location.assign("www.google.com");
}