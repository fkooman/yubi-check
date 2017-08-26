# Introduction

Very simple PHP application to verify a YubiKey OTP at the YubiCo servers.

# Development

    $ git clone https://github.com/fkooman/yubi-check
    $ cd yubi-check
    $ composer install

To run PHP's built in web server:

    $ php -S localhost:8080 -t web/

You should be able to use the application now by browsing to 
[http://localhost:8080/](http://localhost:8080/).

# Tests

Run the unit tests:

    $ phpunit tests --verbose --color

Code coverage reporting:

    $ phpunit tests --verbose --color --whitelist src --coverage-html coverage
