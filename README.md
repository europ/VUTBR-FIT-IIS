# [IIS - Information Systems](https://www.fit.vutbr.cz/study/courses/index.php.en?id=12157)
## © Marek Schauer & Peter Šuhaj & Adrián Tóth
### DEADLINE: 4.12.2017 :bangbang: :clock12:


---

[xsuhaj02-InformationSystem](http://176.116.112.97)


[Patternfly stylesheet](https://www.patternfly.org/pattern-library/widgets/)

---


### TODO:
* Implement assignment :white_check_mark:
* Set up laravel framework :white_check_mark:
* Set up repo :white_check_mark:
* Set up [Gitter](https://gitter.im/) :negative_squared_cross_mark:
    * Use [Facebook](https://www.facebook.com/) :white_check_mark:
* Implement database :white_check_mark:
	* selects :white_check_mark:
	* tables :white_check_mark:
		* create :white_check_mark:
		* drop :white_check_mark:
* Choose frontend template :white_check_mark:
* Implement authorization to information system (admin/pharmacist) :white_check_mark:
* Implement types of views :white_check_mark:
	* medicines :white_check_mark:
	* employees :white_check_mark:
	* distributors :white_check_mark:
	* offices :white_check_mark:
	* insurances :white_check_mark:
	* reservations :white_check_mark:
* Other :white_check_mark:


---


### Assignment, Use Case, Entity-relationship model:

* [Official assignment](https://www.fit.vutbr.cz/study/courses/IIS/private/projekt/.cs)
* Assignment, Use Case, Entity-relationship model: [`assign/xsuhaj02_xschau00.pdf`](https://github.com/europ/VUTBR-FIT-IIS/blob/master/assign/xsuhaj02_xschau00.pdf)


---


### Problems with local repository update

* https://stackoverflow.com/questions/1125968/how-do-i-force-git-pull-to-overwrite-local-files
```sh
git stash # save your changes you have made
git fetch --all
git reset --hard origin/master
git stash pop # load your saved changes back
```


---


### FIX:
* Change `DocumentRoot` in `/etc/apache2/sites-available/000-default.conf` to:
```
DocumentRoot /var/www/html/IIS/public
```

* Add to `/etc/apache2/sites-available/000-default.conf`:
```
	<Directory /var/www/html/IIS/public>
		Options Indexes FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>
```


* Run this command in terminal:
```
service apache2 reload
```


---


### How to:
* [README LaraFly](https://github.com/europ/VUTBR-FIT-IIS/blob/master/README-LaraFly.md)
* [README Backup](https://github.com/europ/VUTBR-FIT-IIS/blob/master/backup/README-backup.md)
