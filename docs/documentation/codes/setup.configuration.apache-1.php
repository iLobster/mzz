AddDefaultCharset UTF-8
RewriteEngine on
Options +FollowSymlinks -Indexes -Includes -MultiViews
# +MultiViews
RewriteBase /
RewriteCond %{SCRIPT_FILENAME} !-f
#Uncomment next line if you want no rewrite exists folders
#RewriteCond %{SCRIPT_FILENAME} !-d

#Uncomment next line if mzz installed not in web-root
#RewriteCond %{REQUEST_URI} !^/mzz/www/?$
RewriteRule (.*) index.php?path=/$1&%{QUERY_STRING} [L]