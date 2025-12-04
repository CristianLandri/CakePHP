Guía rápida para subir este proyecto a GitHub

Pasos rápidos (PowerShell):

1) Abre PowerShell en la raíz del proyecto:

```powershell
cd E:\Xammp\htdocs\Cakephp
```

2) (Opcional) Inicializar repo si aún no existe y hacer el primer commit:

```powershell
# Inicializar (si no existe)
git init
# Añadir todos los archivos (respeta .gitignore)
git add .
# Primer commit
git commit -m "Initial commit"
```

3) Crea un repositorio nuevo en GitHub (usa la web o `gh`):

- Web: https://github.com/new
- gh (si tienes la CLI instalada):
  ```powershell
  gh repo create USER/REPO --public --source=. --remote=origin --push
  ```

4) Añadir remote y subir (si creaste el repo por la web):

```powershell
# sustituyes la URL por la de tu repo
git remote add origin https://github.com/USER/REPO.git
# renombra a main y sube
git branch -M main
git push -u origin main
```

5) Alternativa: usar el script helper que incluí (`scripts\push_to_github.ps1`):

```powershell
# Ejecuta desde la carpeta del proyecto
cd E:\Xammp\htdocs\Cakephp
# Llama al script con la URL de tu repo
.\scripts\push_to_github.ps1 -RemoteUrl "https://github.com/USER/REPO.git" -CommitMessage "Initial commit"
```

Nota sobre autenticación:
- En Windows es recomendable usar el Git Credential Manager o la CLI `gh` para autenticarte con un PAT.
- No pegues tu token en URLs públicas. Si lo necesitas temporalmente, usa `gh auth login` o configura el depósito con el helper de credenciales.

Archivos que te recomiendo no subir (ya en `.gitignore`):
- `cms/cms_app/config/app_local.php` (credenciales locales)
- `cms/cms_app/tmp/`, `cms/cms_app/logs/`
- `vendor/` (si prefieres no versionar dependencias)

Si quieres, puedo:
- Crear el repositorio en GitHub mediante la CLI `gh` (si me confirmas que tienes `gh` y estás conectado),
- O ejecutar los comandos de commit/push desde aquí (necesitarás autenticar en tu máquina).
