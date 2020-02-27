# sso-test backend

## use 
  * [php-mvc](https://github.com/daveh/php-mvc) a light php MVC framework

## Install

### Add dependencies

```
 $ cd backend
 $ composer install
```

### Edit Configuration

Configuration settings are stored in the [\App\Config](/backend/App/Config.dist.php) class. 
Copy `App/Config.dist.php` to `App/Config.php` and edit your configuration

You must also copy [public/.htacess.dist](/backend/public/.htaccess.dist) to your `public/.htaccess` and uncomment or modify the `RewriteBase` directive if needed.

### Server Configuration

With Apache, `/etc/apache2/sites-available/my-site-ssl.conf` the  configuration file of your site `https://my-site.fr` should look like:

```html
<VirtualHost *:443>  
  ServerName my-site.fr  
  # SSL Configuration
  SSLEngine On
  SSLCertificateFile /path-to-certificate-file.pem
  SSLCertificateKeyFile /path-to-my-site-private-key.pem
  ...
  # the backend application entry point 
  DocumentRoot /var/www/sso-tests/public
  <Directory /var/www/sso-tests/public>    
    Options FollowSymLinks  
    AllowOverride All  
  </Directory>   
</VirtualHost>
```

