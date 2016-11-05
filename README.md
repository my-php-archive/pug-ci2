### Important 
If you don't want to clone repo

* Add vendor autoload to CI index.php preview download.
* Add core/MY_Loader.php to {app}/core  *Skip this one, only if error*
* Add Jade and pug library to your app libraries

If not add pug class extending jade, use jade instead pug.


### How to use
```php

$this->load->library("pug",$options);

```

### Works similar to parser
```php
$data = array();

#Parsing multiple views in another view
$module["content"] = $this->pug->view("index",$data,true);
$this->pug->view("template",array_merge($data,$module));


#Loading a simple view
$this->pug->view("privacy_notice");

#Without params print a view named identical to method 
// 1.- {app}/views/{method}
// 2.- {app}/views/{class}/{method}

$this->pug->view();
$this->pug->view($data);

//Same to
$this->pug->view($data,true);

//Or
$this->pug->view(true);
```

###Issues

Pug-php issues at moment. Please check official repo.

https://github.com/pug-php/pug