# JQueryAjaxBundle 
------------------

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a735dceb-683c-4195-bd27-af676ca50a05/small.png)](https://insight.sensiolabs.com/projects/a735dceb-683c-4195-bd27-af676ca50a05)


JQueryAjaxBundle for Symfony2.

## Install
To install this bundle on your project, add this line to composer.json file:

```json
   "mabs/jquery-ajax-bundle": "~1.0"
```

This bundle add two Twig functions:


##1 - ja_request:


  To generate a js code to send an ajax request:
  
```twig
  {{ ja_request({'update': '#reponse', 'url': path('new')  }) }}
```
  
  or
  
```twig
{{ ja_request({'update': '#reponse', 'url': path('new'), 'after': 'alert("after");', 'before': 'alert("before");', 'complete': 'alert("complete");'  }) }}
```
  
  =>
```html
  $.ajax({ url: "/app_dev.php/new", type: "POST", dataType: "html",beforeSend: function(){alert("before");},success: function( data ){$( "#reponse" ).html(data);alert("after");}});
```

##2 - ja_link:



  To generate a link:
  
```twig  
  {{ ja_link({'update': '#reponse', 'url': path('new'), 'text': 'new link'  }) }}
```

  To add a confirm action on click, you just have to use 'confirm': true, by default the text is "Are you sure you want to perform this action?"
  then if you want to replace it, use 'confirm_msg': "***".

  You can also use those parameters 'before' and 'after' to execute JS code.


##3 - License

  This bundle is available under the [MIT license](LICENSE).
 
