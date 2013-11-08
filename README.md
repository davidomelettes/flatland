Omelettes\Quantum Flatland
==========================

Introduction
------------
This app is cool; and by cool, I mean totally sweet.


Environment Configuration
-------------------------

In order to install and run this application, you will need PHP5, with the following modules:

JSON (php5-json)
An appropriate PDO database drive (e.g. php5-pgsql)



Installation using Composer
---------------------------
This application uses Composer for dependency management. Project dependencies are specified in composer.json, and installed by executing the Composer binary:

    php composer.phar self-update
    php composer.phar install

If Composer gives you shit about missing a missing json_decode() function, you may need to install the json module for PHP:

    sudo apt-get install php5-json

The vendor directory should now contain the project dependencies.


Virtual Host
------------
Afterwards, set up a virtual host to point to the public/ directory of the
project and you should be ready to go!

Alternatively — if you are using PHP 5.4 or above — you may start the internal PHP cli-server in the public
directory:

    cd public
    php -S 0.0.0.0:8080 index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.
