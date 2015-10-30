#Welcome to Plasticine!<br/>
The PHP framework only supports Linux,<br/>
Our purpose: high scalability, flexible,minimalism<br/>


#First

Give full rights to directory<br/>
For example:chmod -R 777 /Plasticine<br/>
Need to open rewrite<br/>
Make public directory to become DocumentRoot(apache) or root(nginx)<br/>

Apache:<br/>

Options +FollowSymLinks<br/>
RewriteEngine On<br/>

RewriteCond %{REQUEST_FILENAME} !-d<br/>
RewriteCond %{REQUEST_FILENAME} !-f<br/>
RewriteRule ^ index.php [L]<br/>

Nginx:<br/>

location / {<br/>
    try_files $uri $uri/ /index.php?$query_string;<br/>
}<br/>

#Second

Default support:Mongodb<br/>
So you have to open the PHP extension:mongodb.so<br/>
http://pecl.php.net/package/mongo<br/>

#Then

You have to configure database.conf in the conf directory.<br/>
You can new MongoQuery in controller and module and so on<br/>

#Last

test:<br/>
http://127.0.0.1/?name=yourname<br/>
if show:Welcome to Plasticine!yourname<br/>
then OK!but maybe your IP is not 127.0.0.1<br/>

