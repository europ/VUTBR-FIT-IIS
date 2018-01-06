# [IIS - Information Systems](https://www.fit.vutbr.cz/study/courses/index.php.en?id=12157)
## © Marek Schauer & Peter Šuhaj & Adrián Tóth


---

[Hosting(official)](http://iis-projekt.party/) at [iis-projekt.party](http://iis-projekt.party/)

---


### Assignment, Use Case, Entity-relationship model:

* [Official assignment](https://www.fit.vutbr.cz/study/courses/IIS/private/projekt/.cs)
* Assignment, Use Case, Entity-relationship model: [`assign/xsuhaj02_xschau00.pdf`](https://github.com/europ/VUTBR-FIT-IIS/blob/master/STUFF/assign/xsuhaj02_xschau00.pdf)


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
