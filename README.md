# Curso / Libro: Prime­ros pasos con Laravel 12 + Inertia 2

Repositorio base para acompañar el curso y libro **Primeros pasos con Laravel 12 + Inertia 2**, ideal para aprender a desarrollar aplicaciones web modernas con **Laravel**, **Inertia** y **Vue**.

https://www.desarrollolibre.net/libros/primeros-pasos-laravel-inertia
https://www.desarrollolibre.net/blog/laravel/curso-primeros-pasos-con-laravel-inertia-vuejs-y-tailwindcss

---

##  Descripción

Este proyecto está diseñado como base práctica para el libro/tutorial *Primeros pasos con Laravel 12 + Inertia 2*, escrito por **Andrés Cruz Yoris**. El material guía a los lectores paso a paso desde la instalación hasta la implementación de funcionalidades avanzadas como CRUD, subida de archivos, componentes Vue integrados, modal dialogs, búsqueda, drag & drop y pruebas con PHPUnit :contentReference[oaicite:1]{index=1}.

---

##  Contenido del curso / libros

La obra cubre un total de **17 capítulos**, con el siguiente temario recomendado:

1. Qué es Laravel Inertia y qué aporta.  
2. Crear un proyecto con Laravel e Inertia.  
3. Estructura básica del proyecto.  
4. CRUD básico con componentes Vue vía Inertia.  
5. Redirecciones y mensajes flash.  
6. CRUD completo para posts.  
7. Subida de archivos con plugins externos.  
8. Uso de CKEditor como plugin de Vue.  
9. Diálogos de confirmación y mensajes tipo toast con plugins.  
10. Formularios paso a paso.  
11. Filtros y campo de búsqueda en listados.  
12. Ordenación de columnas en tablas.  
13. Módulo de blog: listado y detalle.  
14. Carrito de compras con CRUD completo.  
15. Opciones avanzadas para peticiones con Inertia.  
16. Aplicación tipo to-do list con drag & drop.  
17. Pruebas unitarias y de integración con PHPUnit.  
:contentReference[oaicite:2]{index=2}

---

##  Estado del repositorio

Este repositorio contiene la plantilla inicial con la estructura básica del proyecto (carpetas como `app/`, `resources/`, `routes/`, configuración de `package.json`, `vite.config.ts`, Tailwind, PHPUnit, etc.) :contentReference[oaicite:3]{index=3}. A medida que avances en el curso o el libro, podrás añadir la lógica específica de cada capítulo en este repositorio.

---

##  Cómo usar este repositorio

### Requisitos previos

- PHP, Composer, Node.js, NPM/Yarn.  
- Conocimiento básico de Laravel, Vue.js e Inertia (parte del curso).

### Instalación inicial

```bash
git clone https://github.com/libredesarrollo/book-course-laravel-inertia.git
cd book-course-laravel-inertia
composer install
npm install   # o yarn install
cp .env.example .env
php artisan key:generate
npm run dev   # compila assets
php artisan serve
