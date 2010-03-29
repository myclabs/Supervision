setCommentaire = function(text, image)
{
	var attributesClear = {top: { to: 62 } };
	var CommDiv = document.getElementById("Commentaire");
	CommDiv.style.visibility = "visible";
	CommDiv.style.top = "88px";
	var old_text = CommDiv.firstChild;
	CommDiv.removeChild(old_text);
	old_text = CommDiv.firstChild;
	if (old_text)
		CommDiv.removeChild(old_text);
	var newText = document.createTextNode(text);
	var newImage = document.createElement("img");
	newImage.setAttribute("src",image);

	CommDiv.appendChild(newImage);
	CommDiv.appendChild(newText);
	var animClear = new YAHOO.util.Anim('Commentaire', attributesClear);

	YAHOO.util.Event.on('Commentaire', 'click', function() { animClear.animate(); });
}