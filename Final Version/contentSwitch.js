
/**
 * File is going to be used for swutching out the src of the content's iframe
 */

function showSRC(address){

     //window.alert("Hello world");

     //Get the section's DOM element
     var sectionDOM = document.getElementById("contentFrame");

     //Now, set the source of the DOM
     sectionDOM.src = address;
}

/**
 * Will eventually redirect to the homepage then open the iframe page address provided
 */
function goHomeAnd(address){

    // window.alert("Hello World 2");

     //Navigate to the home page
     window.location.href = "ProfilePage.html";

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
     obj.style.height = (obj.contentWindow.document.body.scrollHeight + 100) + 'px';
  }