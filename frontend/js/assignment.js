/* change the content of the col4-box every 30 seconds */
window.onload = function(e){ 
	var col4Boxes = document.getElementsByClassName("col4");
	var countCol4Boxes = col4Boxes.length;
	setInterval(function(){
		var displayedCol4Box = null;
		for (i = 0; i < col4Boxes.length; i++) {
			if(!col4Boxes[i].classList.contains("display-none")) {
				displayedCol4Box = i;
			}
		}
		if(displayedCol4Box !== null) {
			col4Boxes[displayedCol4Box].classList.add('display-none');	// hide showed box
			if(displayedCol4Box < (col4Boxes.length - 1)) {	
				// show next box
				col4Boxes[displayedCol4Box + 1].classList.remove('display-none');	// show hidden box
			} else {
				// show first box
				col4Boxes[0].classList.remove('display-none');	// show hidden box
			}
		} 
	}, 3000)
}

/* hide more info */
function hide(e){
	var temp = e.innerHTML;

	e.innerHTML = e.parentNode.nextSibling.nextSibling.innerHTML;
	e.parentNode.nextSibling.nextSibling.innerHTML = temp;
	e.classList.remove('moreInfo');
	e.previousSibling.previousSibling.classList.remove('display-none');
}

/* show more info */
function show(e){
	var temp = e.innerHTML;
	e.innerHTML = e.parentNode.nextSibling.nextSibling.innerHTML;
	e.parentNode.nextSibling.nextSibling.innerHTML = temp;	
	e.classList.add('moreInfo');
	e.previousSibling.previousSibling.classList.add('display-none');
}

function selectRadioImg() {
	console.log("selectRadioImg()");
	var elem = document.getElementById("file_upload");
	console.log(elem);
	elem.setAttribute('accept', '.jpg,.jpeg,.png,.gif');
}

function selectRadioVideo() {
	console.log("selectRadioVideo()");
	var elem = document.getElementById("file_upload");
	console.log(elem);
	elem.setAttribute('accept', '.mp4,.ogv,.ogg,.avi,.flv');
}
