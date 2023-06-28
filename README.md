# Pimcore Blog Project

This is a demo project for setting up a blog from Pimcore Skeleton
## Getting started
## Docker
Clone the repository and run `docker-compose up -d` to start the containers.
```bash
git clone https://github.com/aashan10/pimcore-blog.git && \
cd pimcore-blog && \
docker-compose up -d
```
### Install Pimcore
Get inside the `php` image by running `docker-compose exec php bash` and install pimcore
```bash
composer install && ./vendor/bin/pimcore-install
```
Once that is completed, visit `http://localhost/admin` and login with the credentials you provided during the installation.

### Page Setup

#### Footer Setup
- On the admin panel, go to `Documents` and create a folder named `snippets`.
The folder name is not strict, so you can choose whatever name you like.
- Now, right-click the folder and select `Add Snippet > Footer > Footer Snippet` and name it `footer`.
- Inside the newly created document, place the information (like links, copyright information, address etc.) that you want to see in the footer section of the pages.
- Click the root document and goto `Navigation & Properties` tab.
- On the `Predefined Properties` dropdown at top, select `Footer Snippet`.
- Now drag and drop the previously created `footer` snippet to the newly created entry in the pre-defied properties.
- Make sure to check the `ineritable` checkbox if it is not already checked.
- If you wish to override the footer snippet on any page, you can do so by modifying the pre-defined property `footer_snippet` in the document properties as we did earlier.

#### Navigation Setup
- Any top level pages that you might add are already included in the navigation along with their direct first level children as sub-menu items
- If you add any `BlogCategory` dataobject, those are also listed in the main navigation under the `Categories` menu.


## IMPORTANT
- The blog page url is `/blog/{slug}` because if done as suggested in the assignment, the url would be `/{slug}` which would be a bad idea because the url directly conflicts with the document url and might cause unexpected behaviours.
- 
