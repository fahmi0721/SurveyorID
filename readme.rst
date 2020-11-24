###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

*******************
Server Configuration on GCP Compute Engine
*******************
- Update Apache.conf in /etc/apache2/apache2.conf -> change Allowoveride None to Allowoveride All in line 172
- add package php-mysql, if using Cloud SQL as Database Server 
- if your local development using MariaDB, use Cloud SQL MySQL Version 8.0 as Database Server
- Update Mod_Rewrite Server to make htaccess running well on GCP Compute Engine with command: sudo a2ensite rewrite
- Restart Apache Server -> sudo systemctl restart apache2

*******************
Automation on GCP Compute Engine
*******************
Important Note: 
- Upload apache2.conf configured to Repository, automation will remove after use
- if your repository are private, try to add git config on hash below 

=====START CODE=====

- sudo apt-get update -y
- sudo apt-get install apache2 php git php-mysql -y
- sudo rm -f /var/www/html/index.html
- #git-config
- sudo git clone <git link> /var/www/html
- sudo chmod -R 755 /var/www/html/ 
- sudo cp /var/www/html/apache2.conf /etc/apache2/
- sudo rm -f /var/www/html/apache2.conf
- sudo a2enmod rewrite
- sudo systemctl restart apache2 

=====END CODE=====

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
