#!/bin/bash
# find-ngrok.sh - locate ngrok.exe on Windows drives and cd to its folder

echo "Searching for ngrok.exe on your Windows drives..."

# Common locations
DIRS=(
    "/mnt/c/ngrok"
    "/mnt/c/Users/$USER/Downloads"
    "/mnt/c/Program Files/ngrok"
    "/mnt/d/ngrok"
    "/mnt/e/ngrok"
)

# First, check the PATH (via command -v)
if command -v ngrok.exe &>/dev/null; then
    NGROK_PATH=$(command -v ngrok.exe)
    NGROK_DIR=$(dirname "$NGROK_PATH")
    echo "Found ngrok in PATH: $NGROK_DIR"
    cd "$NGROK_DIR"
    echo "Changed directory to $NGROK_DIR"
    exit 0
fi

# Otherwise, search in common locations
for dir in "${DIRS[@]}"; do
    if [ -f "$dir/ngrok.exe" ]; then
        echo "Found ngrok.exe in $dir"
        cd "$dir"
        echo "Changed directory to $dir"
        exit 0
    fi
done

# If not found, offer to download
echo "ngrok.exe not found."
echo "You can download it from https://ngrok.com/download (Windows version)."
echo "Unzip it to C:\\ngrok and then run this script again."
exit 1
