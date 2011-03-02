setMessage = function(texte, srcImage)
{
	var InfoDiv = document.getElementById("Informations");

	// La partie suppression de message.
	if ((texte == null) || (texte == '')) {
		InfoDiv.innerHTML = "";
		return;
	} else {
        var html = '';

        // Création de la liste et de la croix de fermeture.
        html += '<ul>';
        html += '<span id="croix" onclick="setMessage(null)"><img  src="icons/ui/croix.png" alt="fermer"/></span>';

        html += '<li>';
        // Ajout de l'image.
        if ((srcImage == null) || (srcImage == '')) {
            // Image par défaut.
            srcImage = 'icons/ui/information.png';
        }
        html += '<img alt="" src="' + srcImage + '" />';

        html += '<span class="text">' + texte + '</span>';

        html += '</li>';
        html += '</ul>';

        InfoDiv.innerHTML = html;

        var elements = document.getElementsByTagName('*');
        var zIndex = 0;
        for(var i = 0; i < elements.length; i++) {
            zIndex = Math.max(zIndex,elements[i].style.zIndex);
        }
        InfoDiv.style.zIndex = zIndex + 2;

        return;

	}
}

errorHandler = function(o)
{
	response = YAHOO.lang.JSON.parse(o.responseText);
	setMessage(response.message, response.srcImage);
}