Scraper
===



Install dependencies
----

    php composer.phar update


Unit Tests
---

    vendor/phpunit/phpunit/phpunit src/tests
     
     
Goutte turned out ro be painfil to mock ( - the fluent interface threw me). So I mocked Guzzle instead.

     
Console command
---
     
    php app/console bb:scrape 'http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true&orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&langId=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=185749&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true'
    