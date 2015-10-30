#Welcome to Plasticine!
#The PHP framework only supports Linux,
Our purpose: high scalability, flexible,minimalism


#First
Give full rights to directory
For example:chmod -R 777 /Plasticine
Need to open rewrite
Make public directory to become DocumentRoot(apache) or root(nginx)
Apache:

Options +FollowSymLinks
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]

Nginx:
location / {
    try_files $uri $uri/ /index.php?$query_string;
}


#Second
Default support:Mongodb
So you have to open the PHP extension:mongodb.so
http://pecl.php.net/package/mongo

#Then
You have to configure database.conf in the conf directory.
You can new MongoQuery in controller and module and so on

#Last
test:
http://127.0.0.1/?name=yourname
if show:Welcome to Plasticine!yourname
then OK!but maybe your IP is not 127.0.0.1

