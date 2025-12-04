<#
PowerShell helper to initialize a git repo (if needed), create an initial commit
and push to a GitHub remote. It does not store tokens — use Git credential manager or gh CLI.
Usage:
  .\push_to_github.ps1 -RemoteUrl "https://github.com/USER/REPO.git" -CommitMessage "Initial commit"
#>
param(
    [Parameter(Mandatory=$true)]
    [string]$RemoteUrl,

    [string]$CommitMessage = "Initial commit from local workspace"
)

Push-Location -Path (Resolve-Path "..\") > $null 2>&1
$root = (Get-Location).Path
Write-Host "Working in: $root"

if (-not (Test-Path "$root\.git")) {
    Write-Host "No git repo found — inicializando..."
    git init
    git add .
    git commit -m "$CommitMessage"
} else {
    Write-Host "Repositorio git ya existe. Añadiendo cambios y commiteando..."
    git add .
    git commit -m "$CommitMessage" -q 2>$null
}

# Set main branch name and remote
$branch = "main"
# Create or rename current branch to main
try {
    git branch --show-current | Out-Null
    git branch -M $branch
} catch {
    git checkout -b $branch
}

# Add or update remote
$existing = git remote | Select-String -Pattern "origin" -Quiet
if (-not $existing) {
    git remote add origin $RemoteUrl
    Write-Host "Remote 'origin' agregado: $RemoteUrl"
} else {
    git remote set-url origin $RemoteUrl
    Write-Host "Remote 'origin' actualizado a: $RemoteUrl"
}

Write-Host "Intentando push a origin/$branch (se pedirá credencial si es necesario)..."
git push -u origin $branch

Write-Host "Push completado (si no hubo errores). Revisa tu repositorio en GitHub." 
Pop-Location > $null 2>&1
