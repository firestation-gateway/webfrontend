

## Test at incus container

    incus launch images:ubuntu/22.04/cloud web1 --profile default --profile cloud-ubuntu-lamp-stack --profile proxy-8080 --console
    printf "gid 1000 1000\nuid 1000 1000" | incus config set web1 raw.idmap -

Mount sources

    incus config device add web1 web1_path disk source=$(pwd)/www path=/var/www/html  shift=true

Log in to the incus container

    incus exec web1 -- sudo --user ubuntu --login

Install extra dependencies and enable

    sudo apt install php-symfony-yaml
    sudo apt install php-yaml
    sudo systemctl reload apache2

    # add read/write access for webserver
    sudo chgrp www-data /var/www/html/config.yaml
    sudo chmod 0660 /var/www/html/config.yaml

    # sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/web1.conf
    # sudo a2ensite web1
    # chmod 0777 /var/www/web1


## TODO

- WebLogin

    https://github.com/davidmoremad/simple-web-structure-php/tree/master