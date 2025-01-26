#!/bin/bash
# Run the consume command
php bin/console enqueue:consume --setup-broker &

# Start the main application
php-fpm
