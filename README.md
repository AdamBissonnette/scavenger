Scavenger
========

This is a simple project to create and run sms/mms based scavenger hunts with Twilio using PHP and things

# Dependencies

* PHP >= 5.4
* [Composer](https://getcomposer.org/)
* Node.js >= 0.10
* npm >= 2.1.5 (`npm install -g npm@latest`)

# Installation

* Install PHP Dependencies: composer install
* Create DB: vendor/bin/doctrine orm:schema-tool:create
* Update DB: vendor/bin/doctrine orm:schema-tool:update --force
* Delete DB: vendor/bin/doctrine orm:schema-tool:drop --force (Note: this won't actually delete your sqlite.db file!)

#DB Diagram
* ![alt tag](https://raw.githubusercontent.com/j--w/scavenger/master/db.png)
