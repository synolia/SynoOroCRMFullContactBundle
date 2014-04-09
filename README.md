SynoFullContactBundle
=====================

This extension adds the possibility to get from FullContact API some social informations (Twitter, LinkedIn, Facebook and GooglePlus) about your contacts. Everytime you add an email adress to a contact, the extension fetch data from FullContact API. This document contains information on how to download, install "OroCRM Contact Us" package.

Table of content
-----------------

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Use as dependency in composer](#use-as-dependency-in-composer)

Requirements
------------

SynoFullContactBundle requires OroPlatform(BAP), OroCRM and PHP 5.4.4 or above.

Installation
------------

**Package is available through Oro Package Manager**, you can install it with the following extension key : ```synolia/syno-orocrm-fullcontact```. 

For development purposes it might be cloned from github repository directly.

```bash
git clone https://github.com/synolia/SynoFullContactBundle.git
```

Configuration
-------------

In order to use SynoFullContact properly, you need to get a FullContact API key at this adress:
https://www.fullcontact.com/developer/try-fullcontact/

And then, you must set the API key in

*System > Configuration > General setup > Services > FullContact API*

Use as dependency in composer
-----------------------------

```yaml
"require": {
    "synolia/syno-orocrm-fullcontact": "dev-master",
}
```
