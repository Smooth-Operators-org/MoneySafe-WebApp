# MoneySafe-WebApp

## Primeros pasos
- Tener instalado todo lo necesario, XAMPP, Composer, Visual Studio Code o SublimeText.
- Clonar repositorio.
- Una vez clonado el repo, dirigete a la rama ***Sandbox***, es ahí donde trabajaremos.
 - Puedes cambiar de rama con el ***siguiente comando:***
    ```
    git checkout sandbox
    ```
- Ahora instala las dependencias fundamentales para el proyecto.
 - Recuerda abrir la ventana de comandos apuntando hacía la carpeta del proyecto.
    ```
    composer install
    ```
- Puedes agregar paquetes al composer.json, entra a: [Packagist](https://packagist.org/) página oficial de paquetes para composer.

## Subir un cambio
1. Crea una rama en base a ***sandbox.***
 - Estando en la rama sandbox ***ejecuta*** el sig. comando:
    ```
    git checkout -b "nombre de tu rama"
    ```
2. El nombre de tu rama creada debe ser ***referente al cambio que subirás.***
3. Realiza tus cambios, haz Commit ***(Asegúrate de incluir tus cambios en un solo Commit)*** y sube los cambios a tu rama.
4. Asegúrate que la ***rama sandbox se encuentre actualizada***, de lo contrario debes de ***hacer pull con rebase a sandbox***, si haces merge crearás un commit más.
```
git rebase sandbox
```
5. Una vez terminado, debes crear un ***pull request hacía la rama sandbox y listo***, se verificaran tus cambios y se integrarán al proyecto.

## Integrantes del equipo
- ***Alan Jair Cauich Salas***
- Armando Robles Palomares
- Luis Fernando
- Diana Gonzalez
