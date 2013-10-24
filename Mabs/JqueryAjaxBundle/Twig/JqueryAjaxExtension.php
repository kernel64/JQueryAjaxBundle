<?php

namespace Mabs\JQueryAjaxBundle\Twig;

class JqueryAjaxExtension extends \Twig_Extension
{

    public function getFunctions()
    {
    	return array(
    			new \Twig_SimpleFunction('ja_request', $this->remoteCall()),
    			new \Twig_SimpleFunction('ja_link', $this->linkTag())
    	);
    }
    /**
     *  create Js function to call remote URL
     * 
     */
    public function remoteCall($options = array()) {
    	return function($options) {
    				$type = isset($options['type'])?$options['type']:"POST";
    				$dataType = isset($options['dataType'])?$options['dataType']:"html";
			    	$js = '$.ajax({
							url: "'.$options['url'].'",
							type: "'.$type.'",
							dataType: "'.$dataType.'",';
			    	
			    	if(isset($options['before']))
			    	{
			    		$js .= 'beforeSend: function(){'.$options['before'].'},';
			    	}

					$js .= 'success: function( data ){$( "'.$options['update'].'" ).html(data);';					
					$js .= isset($options['after'])?$options['after']:"";
					$js .= '}});';
					
					return $js;
		    	}
    	;
    }
    
    public function linkTag($options = array()) {
    	$jsRequest = $this->remoteCall();
    	
    	return function($options) use($jsRequest) {
    		$html = "<a class='".(isset($options['class'])?$options['class']:"")."'
    		 		 id='".(isset($options['id'])?$options['id']:"")."'
    		 		 href='".$options['url']."'
    				 onclick='".call_user_func($jsRequest, $options)."return false;'>";
    		$html .= $options['text'];
    		$html .= "</a>";
    		
    		return $html;
    	};
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'mabs_jquery_ajax';
    }

}