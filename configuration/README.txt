Pour que le site web soit fonctionnel, il est n�cessaire de copier les fichiers contenus dans ce dossier � leur emplacement respectif.
- application.ini doit �tre copi� dans application/configs/
- .htaccess doit �tre copi� dans public/

Attention, les fichiers copi�s ne doivent pas �tre upload�s sur le SVN. Il faut donc cr�er une r�gle Ignore sur ces fichiers (Add to ignore list). Ceci est n�cessaire afin que chacun puisse avoir une configuration personnalis�e sur sa machine.
Si jamais quelqu'un modifie un de ces fichiers (modifier les fichiers de ce dossier �galement), il doit en avertir toutes les personnes concern�es pour qu'elles mettent � jour leurs fichiers de configuration personnalis�s.