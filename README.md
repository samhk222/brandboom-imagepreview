Hi there, this repo is regarding the job offer @ https://stackoverflow.com/jobs/204945/lead-full-stack-developer-brandboom

# How to install 

## 1. Clone this repo into your www directory
```
cd /var/www/html/ [enter]
git clone https://github.com/samhk222/brandboom-imagepreview.git
```

## 2. Create the database and import the following script
```
CREATE TABLE `brandboom`.`images` (
  `image_id` INT NOT NULL AUTO_INCREMENT,
  `filepath` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`image_id`));
```
## 3. Rename .env.dist to .env and change the database parameters
- DB
- DB_USER
- DB_HOST
- DB_PASS
You don't need to change the DSN!

## 4. Chmod 777 the folders
- src/files
- src/files/thumbs
`sudo chmod 777 -R src/files src/files/thumbs`

## 5. Access the site
Navigate to http://localhost/brandboom-imagepreview

## 5. Profit!