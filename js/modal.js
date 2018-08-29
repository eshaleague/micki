var elm = document.getElementsByTagName('img');
var length = elm.length;
for (var i = 0; i < length; i++) {
  elm[i].className = elm[i].className + " imageClass";
}
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var images = document.getElementsByClassName("imageClass");
for(var i = 0; i < images.length; i++){
    var img = images[i];
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = this.src;
    }
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}
    
