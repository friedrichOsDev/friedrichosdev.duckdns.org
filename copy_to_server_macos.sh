#!/bin/bash
SOURCE="/Users/friedrich/Documents/Projects/friedrichosdev.duckdns.org/"
DESTINATION="oracle-server:/var/www/html"

# Delete old files on the server
rsync -avz --exclude="copy_to_server.sh" --exclude=".git" --exclude=".gitignore" --exclude=".vscode" --exclude="LICENSE" --exclude="README.md" --delete "$SOURCE" "$DESTINATION"

# Sync the files
rsync -avz --exclude="copy_to_server.sh" --exclude=".git" --exclude=".gitignore" --exclude=".vscode" --exclude="LICENSE" --exclude="README.md" "$SOURCE" "$DESTINATION"