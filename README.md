TzbSendyBundle
===============

This bundle is used to integrate the [SendyPHP class from Jacob Bennett](https://github.com/JacobBennett/SendyPHP) into a symfony2 project.

This bundle is stable and tested.

Installation
============

1. Add it to your composer.json:

    ```json
    {
        "require": {
            "tzb/sendy-bundle": "dev-master"
        }
    }
    ```

    or:

    ```sh
        composer require tzb/sendy-bundle
        composer update tzb/sendy-bundle
    ```

2. Add this bundle to your application kernel:

    ```php
    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Tzb\SendyBundle\TzbSendyBundle(),
            // ...
        );
    }
    ```

3. Configure `ornicar_apc` service:

    ```yaml
    # app/config/config.yml
        tzb_sendy:
            api_key: sendy_api_key
            api_host: http://sendy.installation.com
            list_id: my_list_id // you can set/change it later
    ```

Features
--------

* Integrates SendyPHP library from Jacob Bennett

1.0.0 : 2014/12/10

* first release
