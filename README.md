JQueryAjaxBundle
================

JQueryAjaxBundle for Symfony2.

This bundle add two Twig functions :

1 - ja_request :

  To generate a js code to send an ajax request:
  
  {{ ja_request({'update': '#reponse', 'url': path('new'), 'after': 'alert("after");', 'before': 'alert("before");'  }) }}
  
  =>
  
  $.ajax({ url: "/app_dev.php/new", type: "POST", dataType: "html",beforeSend: function(){alert("before");},success: function( data ){$( "#reponse" ).html(data);alert("after");}});

2 - ja_link:

  To generate a link:
  
  <!--
  
  {{ ja_link({'update': '#reponse', 'url': path('event_new'), 'text': 'new link'  })|raw }}
  
  =>
  
  <a onclick="$.ajax({ url: '/app_dev.php/new', type: 'POST', dataType: 'html',success: function( data ){$( '#reponse' ).html(data);}});return false;" href="/app_dev.php/new" id="" class="">new link</a>
  //-->
