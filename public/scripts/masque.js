setMasque = function(afficherChargement, afficherMasque)
{
    if (typeof(indexChargeMasque) == "undefined") {
        indexChargeMasque = 0;
    }

	var masque = document.getElementById('Masque');
    var divMasque = document.getElementById('CadrePage');
    var divChargement = document.getElementById('CadreChargement');
        
	if (afficherChargement || afficherMasque)
	{
        indexChargeMasque++;
        //alert('++ ' + indexChargeMasque);

        masque.style.visibility = "visible";

        var elements = document.getElementsByTagName('*');
        var zIndex = 0;
        for(var i = 0; i < elements.length; i++) {
            zIndex = Math.max(zIndex,elements[i].style.zIndex);
        }
        masque.style.zIndex = zIndex + 2;

        if (afficherChargement) {
            divChargement.style.visibility = "visible";
        } else {
            divChargement.style.visibility = "hidden";
        }
        
        if (afficherMasque) {
            divMasque.style.visibility = "visible";
        } else {
            divMasque.style.visibility = "hidden";
        }
	}
	else
	{
        indexChargeMasque--;
        //alert('-- ' + indexChargeMasque);

        if (indexChargeMasque <= 0) {
            masque.style.visibility = "hidden";
            divChargement.style.visibility = "hidden";
            divMasque.style.visibility = "hidden";
        }
	}
}

YAHOO.util.Event.addListener(window, "load", function(){setMasque(false, false);});