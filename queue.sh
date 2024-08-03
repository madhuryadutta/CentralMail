#!/bin/bash

# Update package lists
sudo apt update

# Install Supervisor
sudo apt install -y supervisor

# Create Supervisor configuration for Laravel worker
cat <<EOL | sudo tee /etc/supervisor/conf.d/laravel-worker.conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/laravel/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/your/laravel/storage/logs/worker.log
EOL

# Reload Supervisor configuration to recognize new program
sudo supervisorctl reread
sudo supervisorctl update

# Start the Laravel worker
sudo supervisorctl start laravel-worker:*

# Check the status of the Laravel worker
sudo supervisorctl status
