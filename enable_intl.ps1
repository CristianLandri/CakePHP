<#
enable_intl.ps1
Script seguro para habilitar la extensión intl en PHP (XAMPP) y copiar icu DLLs a Apache.
USO (PowerShell):
  .\enable_intl.ps1 -PhpIniPath "E:\Xammp\php\php.ini" -PhpDir "E:\Xammp\php" -ApacheBin "E:\Xammp\apache\bin"

El script:
 - crea una copia de seguridad de php.ini
 - descomenta o añade la línea `extension=php_intl.dll`
 - copia icu*.dll desde la carpeta PHP a la carpeta Apache bin si es necesario
 - imprime los pasos siguientes para reiniciar Apache y verificar
#>
param(
    [string]$PhpIniPath = "E:\\Xammp\\php\\php.ini",
    [string]$PhpDir = "E:\\Xammp\\php",
    [string]$ApacheBin = "E:\\Xammp\\apache\\bin"
)

function Abort($msg){ Write-Error $msg; exit 1 }

if (-not (Test-Path $PhpIniPath)) { Abort("php.ini no encontrado en: $PhpIniPath. Ajusta -PhpIniPath al archivo correcto.") }

$timestamp = Get-Date -Format "yyyyMMddHHmmss"
$backup = "$PhpIniPath.bak.$timestamp"
Copy-Item -Path $PhpIniPath -Destination $backup -Force
Write-Host "Backup creado: $backup"

$content = Get-Content -Raw -LiteralPath $PhpIniPath -ErrorAction Stop
$changed = $false

# Try to uncomment common variants
$pattern = "(?im)^\s*;\s*(extension\s*=\s*(php_intl\.dll|intl))\s*$"
if ($content -match $pattern) {
    $new = [regex]::Replace($content, $pattern, 'extension=php_intl.dll')
    if ($new -ne $content) { $content = $new; $changed = $true }
}

# If not matched, look for uncommented 'extension=intl' or 'extension=php_intl.dll' (nothing to do)
if (-not $changed) {
    if ($content -match "(?im)^\s*extension\s*=\s*(php_intl\.dll|intl)\s*$") {
        Write-Host "La línea de extensión intl ya existe y está descomentada."
    } else {
        # Append the line at the end
        $content = $content + "`r`n; Added by enable_intl.ps1`r`nextension=php_intl.dll`r`n"
        $changed = $true
    }
}

if ($changed) {
    # Write back safely: write to temp then move
    $tmp = "$PhpIniPath.tmp.$timestamp"
    Set-Content -LiteralPath $tmp -Value $content -Encoding UTF8
    Move-Item -Force -LiteralPath $tmp -Destination $PhpIniPath
    Write-Host "php.ini actualizado para habilitar intl."
} else {
    Write-Host "No se hicieron cambios en php.ini."
}

# Copy icu DLLs if exist
$icuFiles = Get-ChildItem -Path (Join-Path $PhpDir "icu*.dll") -ErrorAction SilentlyContinue
if ($icuFiles) {
    if (-not (Test-Path $ApacheBin)) {
        Write-Warning "Directorio Apache bin no encontrado: $ApacheBin. No se copiarán icu DLLs automáticamente."
    } else {
        foreach ($f in $icuFiles) {
            $dest = Join-Path $ApacheBin $f.Name
            if (-not (Test-Path $dest)) {
                Copy-Item -LiteralPath $f.FullName -Destination $dest -Force
                Write-Host "Copiado: $($f.Name) -> $dest"
            } else {
                Write-Host "Ya existe: $dest"
            }
        }
    }
} else {
    Write-Host "No se encontraron icu*.dll en $PhpDir. Esto puede ser normal dependiendo de la instalación."
}

Write-Host "`nSiguientes pasos:`n"
Write-Host "1) Reinicia Apache/XAMPP desde el XAMPP Control Panel (Stop -> Start)."
Write-Host "   Si Apache está instalado como servicio, puedes intentar (ejecutar PowerShell como administrador):"
Write-Host "     Stop-Service -Name 'Apache2.4' -ErrorAction SilentlyContinue"
Write-Host "     Start-Service -Name 'Apache2.4' -ErrorAction SilentlyContinue"
Write-Host "   (Ajusta el nombre del servicio si es distinto.)`n"
Write-Host "2) Verifica en CLI que intl esté cargado:"
Write-Host "     php -m | Select-String intl"
Write-Host "     php --ri intl"
Write-Host "3) Si la extensión no aparece, comprueba los logs de Apache/PHP y revisa que hayas editado el php.ini correcto (CLI vs Apache pueden usar archivos distintos).
"
Write-Host "Hecho. Si quieres, puedes ejecutar este script con:"
Write-Host "  PowerShell -ExecutionPolicy Bypass -File .\enable_intl.ps1 -PhpIniPath \"E:\\Xammp\\php\\php.ini\" -PhpDir \"E:\\Xammp\\php\" -ApacheBin \"E:\\Xammp\\apache\\bin\""
