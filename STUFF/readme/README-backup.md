# [IIS - Information Systems](https://www.fit.vutbr.cz/study/courses/index.php.en?id=12157)
## © Marek Schauer & Peter Šuhaj & Adrián Tóth


### Assignment, Use Case, Entity-relationship model:

* [Official assignment](https://www.fit.vutbr.cz/study/courses/IIS/private/projekt/.cs)
* Assignment, Use Case, Entity-relationship model: [`assign/xsuhaj02_xschau00.pdf`](https://github.com/europ/VUTBR-FIT-IIS/blob/master/STUFF/assign/xsuhaj02_xschau00.pdf)


---


### Setting up laravel ("Hello world!"):

* Run these commands in terminal:
```
sudo apt-get update && sudo apt-get upgrade -y && sudo apt autoremove -y
sudo apt-get install git unzip tasksel curl php-curl php-mcrypt php-mbstring php-gettext phpmyadmin
sudo tasksel install lamp-server
sudo phpenmod mcrypt
sudo phpenmod mbstring
sudo a2enmod rewrite
sudo systemctl restart apache2
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

cd /var/www/html

sudo composer create-project laravel/laravel IIS --prefer-dist
sudo chmod -R 777 ISS
sudo vim /etc/apache2/sites-available/000-default.conf
```

* Change `DocumentRoot` in `/etc/apache2/sites-available/000-default.conf` to:
```
DocumentRoot /var/www/html/IIS/public
```

* Add to `/etc/apache2/sites-available/000-default.conf`:
```
	<Directory /var/www/html/work/public>
		AllowOverride All
		Require all granted
	</Directory>
```


* Run this command in terminal:
```
service apache2 reload
```

* Open browser and type `localhost`.


---


### Setting up REPO:

* Set up laravel ("Hello world!")

* Run these commands in terminal:
```
cd /var/www/html/

sudo cp -R IIS IIS_backup

cd IIS/

sudo rm -rf * .*
sudo git clone https://github.com/europ/VUTBR-FIT-IIS.git .

cd /var/www/html/

sudo chmod -R 777 IIS

cd IIS/

sudo cp .env.example .env
sudo php artisan key:generate
```

* Open browser and type `localhost`.
* If you would like to use SSH, open `.git/config` in text editor

change
```
url = https://github.com/europ/VUTBR-FIT-IIS.git
```
to
```
url = git@github.com:europ/VUTBR-FIT-IIS.git
```

---

### Problems with local repository update

* https://stackoverflow.com/questions/1125968/how-do-i-force-git-pull-to-overwrite-local-files
```sh
git stath # save your changes you have made
git fetch --all
git reset --hard origin/master
git stash pop # load your saved changes back
```
