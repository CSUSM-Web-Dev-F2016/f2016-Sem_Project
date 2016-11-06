

function buildFeed() {
     var max = 5, iterator = 0;
     while (iterator < max) {

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
          subText.innerHTML = "No page has been created for this item yet. Please try another."


          subDiv.appendChild(mainHeader);
          subDiv.appendChild(mainImageDiv);
          subDiv.appendChild(mainImage);
          subDiv.appendChild(subText);

          mainElement.appendChild(subDiv);

          document.getElementById("MainArea").appendChild(mainElement);




          /*
          //Using document.write, create a sample PNF container
          document.write("<div class=\"PNFContainer\">");
          document.write("<div class=\"stdSection\">");
          document.write("<h1 class=\"PNFTitle\">Page Not Found</h1>");
          document.write("<hr>");
          document.write("<div><img class=\"largeImageForPNF\" src=\"https://github.com/CSUSM-Web-Dev-F2016/f2016-Sem_Project/blob/master/Final%20Version/BeerHopperLogo.png?raw=true\" alt=\"Beer Hopper Logo\"></div>");
          document.write("<div class=\"PNFDescription\">  No page has been created for this item yet. Please try another. </div>");
          document.write("</div></div>")
          */
          iterator++;
     }
     //document.body.style.display = "flex";
     //document.body.style.flexDirection = "column";
     //document.body.style.seamless = "seamless";
     //document.body.style.overflow = "hidden";
     //document.body.style.backgroundColor = "red";
     //document.body.style.height = document.contentWindow.document.body.scrollHeight + "px";

     window.alert("Main Frame content size is: " + document.contentWindow.document.body.scrollHeight + " while the iframe is only: " + document.body.style.height);
}