Pour que le site web soit fonctionnel, il est nécessaire de copier les fichiers contenus dans ce dossier à leur emplacement respectif.
- application.ini doit être copié dans application/configs/
- .htaccess doit être copié dans public/

Attention, les fichiers copiés ne doivent pas être uploadés sur le SVN. Il faut donc créer une règle Ignore sur ces fichiers (Add to ignore list). Ceci est nécessaire afin que chacun puisse avoir une configuration personnalisée sur sa machine.
Si jamais quelqu'un modifie un de ces fichiers (modifier les fichiers de ce dossier également), il doit en avertir toutes les personnes concernées pour qu'elles mettent à jour leurs fichiers de configuration personnalisés.