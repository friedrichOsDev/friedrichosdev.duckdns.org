#!/bin/bash
SOURCE="/home/friedrich/Projects/Websites/friedrichosdev.duckdns.org/"
DESTINATION="oracle-server:/var/www/html"

# Delete old files on the server
rsync -avz --exclude="copy_to_server.sh" --exclude=".git" --exclude=".gitignore" --delete "$SOURCE" "$DESTINATION"

# Sync the files
rsync -avz --exclude="copy_to_server.sh" --exclude=".git" --exclude=".gitignore" "$SOURCE" "$DESTINATION"