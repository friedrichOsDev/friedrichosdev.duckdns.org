#!/bin/bash
SOURCE="/home/friedrich/Projects/Websites/friedrichosdev.duckdns.org/"
DESTINATION="oracle-server:/var/www/html"

# Delete old files on the server
rsync -avz --exclude="copy_to_server_linux.sh" --exclude="copy_to_server_macos.sh" --exclude=".git" --exclude=".gitignore" --exclude=".vscode" --exclude="LICENSE" --exclude="README.md" --delete "$SOURCE" "$DESTINATION"

# Sync the files
rsync -avz --exclude="copy_to_server_linux.sh" --exclude="copy_to_server_macos.sh" --exclude=".git" --exclude=".gitignore" --exclude=".vscode" --exclude="LICENSE" --exclude="README.md" "$SOURCE" "$DESTINATION"