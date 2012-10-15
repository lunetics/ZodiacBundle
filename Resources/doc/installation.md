Installation
============
This section shows you how to install this bundle

Add the package to your dependencies
------------------------------------
``` php
"require": {
    "lunetics/zodiac-bundle": "dev-master",
    ....
},
```

Register the bundle in your kernel
----------------------------------
``` php
public function registerBundles()
    {
        $bundles = array(
            // ...
            new Lunetics\ZodiacBundle\LuneticsZodiacBundle(),
        );
```

Update your packages
--------------------
``` sh
php composer.phar update lunetics/zodiac-bundle
```

Configuration
=============
Add the following lines to your app/config/config.yml

``` yaml
lunetics_zodiac: ~
```