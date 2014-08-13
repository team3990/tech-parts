## Tech Parts

Tech Parts is the CAD parts management platform for Équipe Team 3990: Tech for Kids (Collège Regina Assumpta, Montréal, QC). It is live at [parts.team3990.com](http://parts.team3990.com).

## Installation & Deployment
1. You must install & deploy Tech Portal first. 
2. (Optional) On a server, install Composer:   
<code>curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer</code>
3. Extract Tech Parts files into a folder on the server, for example <code>/www/techparts/</code> and set a subdomain to it.
4. Edit <code>app/config/database.php</code> with the correct information to the corresponding database server.
5. Execute Laravel migrations: <code>php artisan migrate<code>

## License

Tech Parts is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
