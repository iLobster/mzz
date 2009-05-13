AddDefaultCharset utf-8

RewriteEngine on
RewriteBase /

Options +FollowSymlinks -Indexes -Includes -MultiViews

# rules for media-files urls rewriting
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteRule ^templates/css/(.*\.css) templates/external.php?type=css&files=$1 [L]

RewriteCond %{SCRIPT_FILENAME} !-f
RewriteRule ^templates/images/(.*\.(gif|png|jpg)) templates/external.php?type=$2&files=$1 [L]

RewriteCond %{SCRIPT_FILENAME} !-f
RewriteRule ^templates/js/(.*\.js) templates/external.php?type=js&files=$1 [L]

RewriteCond %{SCRIPT_FILENAME} !-f
RewriteRule ^templates/js/(.*\.([^.]*)) templates/external.php?type=$2&files=$1 [L]

RewriteCond %{SCRIPT_FILENAME} !-f
#Uncomment the next line if you don't want to rewrite exists folders
#RewriteCond %{SCRIPT_FILENAME} !-d

RewriteRule (.*) index.php?path=/$1&%{QUERY_STRING} [L]

# If magic_quotes enabled in your php.ini and you can't disable it then uncomment the next lines:
#<IfModule mod_php5.c>
#    php_flag magic_quotes_gpc 0
#    php_flag magic_quotes_runtime 0
#</IfModule>

<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType application/x-javascript "access plus 3 day"
    ExpiresByType text/css "access plus 3 day"
    ExpiresByType image/gif "access plus 5 day"
    ExpiresByType image/jpeg "access plus 5 day"
    ExpiresByType image/png "access plus 5 day"
</IfModule>