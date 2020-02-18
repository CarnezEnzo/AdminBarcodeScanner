# fr_FR
## AbandonedCart

* Ce module vous permet de lire des codes-barres dans le back office pour directement modifier un code EAN depuis la page du produit, et d'ajouter un outil permettant
d'ouvrir la page de modification d'un produit depuis son code-barres.

## Installation

### Manuellement

* Copiez ce module directement dans votre répertoire ```<thelia_root>/local/modules/``` et verifier que le nom du module soit AdminBarcodeScanner
* Activez le dans votre back office Thelia

### Composer

Ajoutez cette ligne à votre fichier composer.json au coeur de votre Thélia

```
composer require your-vendor/admin-barcode-scanner-module:~1.0
```

## Usage

* Directement depuis la page d'un produit du back office, vous pouvez modifier l'EAN d'un produit en scannant un code-barres. Attention, une connexion HTTPS est requise
ainsi qu'un appareil compatible pour permettre au module d'acceder à votre caméra.

* Depuis la page de configuration "Code-barres" se trouvant dans les outils, il est aussi possible de rapidement modifier plusieurs code EAN ou d'ouvrir la page de modification d'un produit en scannant son code-barres.

# en_US
## AbandonedCart

* This module allows you to scan barcodes in your back office in order to easily edit a product EAN code from its page, it also allows to quickly open a product update page from its barcode by scanning it.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is AbandonedCart.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require your-vendor/admin-barcode-scanner-module:~1.0
```

## Usage

* Directly from a product page of your back office, you can edit its EAN code by scanning a barcode. Warning, an HTTPS connection is required as well as a supported device to allow the module to access your camera.

* From the configuration page called "Barcode" in the tools category, you can also quickly edit several EAN codes and open a product update page only by scanning its barcode.
