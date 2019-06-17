# The Movie DB module for Magento 2
## How to install The Movie DB module for Magento 2
### 1. Install via composer (recommend)

We recommend you to install Toinhoitacity_Tmdb module via composer. Run the following command in Magento 2 root folder.

#### 1.1 Install

```
composer require toinhoitacity/tmdb
php bin/magento setup:upgrade
```

#### 1.2 Upgrade

```
composer update toinhoitacity/tmdb
php bin/magento setup:upgrade
```

If you are using the Magento platform in the deploy mode default execute this command:

```
php bin/magento setup:di:compile
```

### 2. Copy and paste

If you don't want to install via composer, you can use this way. 

- Download [the latest version here](https://github.com/toinhoitacity/tmdb/archive/master.zip) 
- Extract `master.zip` file to `app/code/Toinhoitacity/Tmdb`; You should create a folder path `app/code/Toinhoitacity/Tmdb` if not exist.
- Go to Magento root folder and run upgrade command line to install `Toinhoitacity_Tmdb`:

```
php bin/magento setup:upgrade
```
