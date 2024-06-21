# initialization project: 

## install laravel version 10 by sail in windows 10:

- `boot docker`
- `use wsl2 terminal`
- `curl -s "https://laravel.build/example-app?php=81" | bash`
- `explorer.exe .` -> open folder in windows
- `./vendor/bin/sail up -d` -> start container
  - `./vendor/bin/sail stop` -> stop container
  - `./vendor/bin/sail down` -> delete container
- `sudo chmod -R 777 .` -> make all files writable
- `composer require laravel/breeze --dev`
- `./vendor/bin/sail bash` -> use bash by sail
- `npm run dev`

