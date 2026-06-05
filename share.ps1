# Find the local IPv4 address
$ip = (Get-NetIPAddress -AddressFamily IPv4 | Where-Object { $_.InterfaceAlias -match "Wi-Fi|Ethernet" -and $_.PrefixOrigin -ne "WellKnown" } | Select-Object -First 1).IPAddress

if (-not $ip) {
    Write-Host "Could not determine IP address. Check your network connection." -ForegroundColor Red
    exit 1
}

Write-Host "Local IP address: $ip" -ForegroundColor Green

# Stop any existing PHP server on port 8000
$existing = Get-Process -Name "php" -ErrorAction SilentlyContinue | Where-Object { $_.MainWindowTitle -match "artisan serve" }
if ($existing) {
    Write-Host "Stopping existing PHP server..." -ForegroundColor Yellow
    $existing | Stop-Process -Force
    Start-Sleep -Seconds 2
}

# Start the Laravel development server on all interfaces
Write-Host "Starting development server..." -ForegroundColor Cyan
$env:APP_URL = "http://$ip`:8000"
Start-Process -NoNewWindow -FilePath "php" -ArgumentList "artisan serve --host 0.0.0.0 --port 8000"

# Wait a moment for the server to start
Start-Sleep -Seconds 4

Write-Host "Server is running. Share this URL with other devices on the same network:" -ForegroundColor Green
Write-Host "http://$ip`:8000" -ForegroundColor White -BackgroundColor DarkGreen

# Keep the window open so the user can see the URL
Read-Host "Press Enter to stop the server and exit"
Get-Process -Name "php" | Where-Object { $_.MainWindowTitle -match "artisan serve" } | Stop-Process -Force
