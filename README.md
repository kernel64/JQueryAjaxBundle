# JQueryAjaxBundle
================



JQueryAjaxBundle for Symfony2.

This bundle add two Twig functions:


##1 - ja_request:
------------------


  To generate a js code to send an ajax request:
  
```twig
  {{ ja_request({'update': '#reponse', 'url': path('new')  }) }}
```
  
  or
  
```twig
{{ ja_request({'update': '#reponse', 'url': path('new'), 'after': 'alert("after");', 'before': 'alert("before");'  }) }}
```
  
  =>
```html
  $.ajax({ url: "/app_dev.php/new", type: "POST", dataType: "html",beforeSend: function(){alert("before");},success: function( data ){$( "#reponse" ).html(data);alert("after");}});
```

##2 - ja_link:
--------------


  To generate a link:
  
```twig  
  {{ ja_link({'update': '#reponse', 'url': path('new'), 'text': 'new link'  }) }}
```

  You can also use those parameters 'before' and 'after' to execute JS code.

 
