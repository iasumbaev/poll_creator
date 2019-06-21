# poll_creator
## Requirements
1. OS Ubuntu
2. Apache web-server
3. MySQL database
4. PHP
## Installation
1. Run your console
2. Type `cd /var/www/your_folder` your_folder - is a root directory of your website
3. Type `git clone https://github.com/iasumbaev/poll_creator.git /var/www/your_folder/polls`
4. Type `nano /etc/apache2/sites-available/000-default.conf`
5. Change `AllowOverride None` to `AllowOverride all`
6. Type `sudo /etc/init.d/apache2 restart`
7. Type `mysql -u your-db-username` your-db-username - is a name of user in MySQL
8. Type `CREATE DATABASE polls;`
9. Type `GRANT ALL PRIVILEGES ON polls.* TO 'your-db-username'@'localhost';`
10. Type `exit`;
12. Type `mysql polls < init_db.sql `
13. Go to `www.your-website-name.xx\polls\create`
14. Use service
