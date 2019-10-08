# Nova Project Manager (NPM)
Laravel & Vue.js web app for organizing projects or other information and storing code snippets.

![Screenshot](https://novalx.com/assets/nova-project-manager-preview.png)

## Features:
- Flexible post type system for creating and storing different types/taxonomies of information
- Post categories/taxonomies with hierarchy support
- Menu management system with custom class and Font Awesome icon support
- Authentication flow and user management system (only admin can add users for now, no registration flow for guests)
- Search system (dedicated search page and AJAX search field in page headers) with fuzzy matching
- Markdown content editor
- Fast and lean

## Installation
1. Clone repository
2. Navigate to repository directory and open a terminal
3. Run `composer install`
4. Configure database credentials in ".env" file
5. Run `php artisan migrate` to create necessary tables in your database
