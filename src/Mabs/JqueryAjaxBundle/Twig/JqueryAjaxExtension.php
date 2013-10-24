<?php

namespace Mabs\JQueryAjaxBundle\Twig;

class JqueryAjaxExtension extends \Twig_Extension
{

    public function getFunctions()
    {
    	return array(
    			new \Twig_SimpleFunction('ja_request', $this->remoteCall(), array('is_safe' => array('html'))),
    			new \Twig_SimpleFunction('ja_link', $this->linkTag(), array('is_safe' => array('html')))
    	);
    }
    
    /**
     * Generate Js function to send ajax request.
     * 
     * @param array $options
     */
    public function remoteCall($options = array()) {
    	return function($options) {
    				$type = isset($options['type'])?$options['type']:"POST";
    				$dataType = isset($options['dataType'])?$options['dataType']:"html";
			    	$js = "$.ajax({
							url: '".$options['url']."',
							type: '".$type."',
							dataType: '".$dataType."',";
			    	
			    	if(isset($options['before']))
			    	{
			    		$before = str_replace('"', "'", $options['before']);
			    		$js .= "beforeSend: function(){".$before."},";
			    	}

					$js .= "success: function( data ){ $('".$options['update']."').html(data);";	
					
					if(isset($options['after'])) {
						$after = str_replace('"', "'", $options['after']);
						$js .= $after;
					}
			
					$js .= "}});";
					
					return $js;
		    	}
    	;
    }
    
    /**
     * Generate link tag with js function to send ajax request
     * 
     * @param array $options
     */
    public function linkTag($options = array()) {
    	$jsRequest = $this->remoteCall();
    	
    	return function($options) use($jsRequest) {
    		$html = '<a class="'.(isset($options['class'])?$options['class']:"").'"
    		 		 id="'.(isset($options['id'])?$options['id']:"").'"
    		 		 href="'.$options['url'].'"
    				 onclick="'.call_user_func($jsRequest, $options).'return false;">';
    		$html .= $options['text'];
    		$html .= '</a>';
    		
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
