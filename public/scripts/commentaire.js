setCommentaire = function(texte, titre, srcImage)
{
	var InfoDiv = document.getElementById("Informations");
    
	//la partie suppression de message
	if ((texte == null) || (texte == '')) {
		InfoDiv.innerHTML = "";
		return;
	} else {
        var html = '';

        // Création de la liste et de la croix de fermeture.
        html += '<ul>';
        html += '<span id="croix" onclick="setCommentaire(null)"><img  src="../icons/croix.png" alt="fermer"/></span>';

        html += '<li>';
        // Ajout de l'image.
        if ((srcImage == null) || (srcImage == '')) {
            // Image par défaut.
            srcImage = '../icons/information.png';
        }
        html += '<img alt="" src="' + srcImage + '" />';

        // Ajout du titre si présent.
        if ((titre == null) || (titre == '')) {
            html += '<span class="titre">' + titre + '</span>';
        }

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