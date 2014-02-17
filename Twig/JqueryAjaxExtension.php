<?php
namespace Mabs\JQueryAjaxBundle\Twig;

/**
 *
 * @author Mohamed Aymen Ben Slimane <med.aymen3@gmail.com>
 *        
 */
class JqueryAjaxExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('ja_request', $this->remoteCall(), array(
                'is_safe' => array(
                    'html'
                )
            )),
            new \Twig_SimpleFunction('ja_link', $this->linkTag(), array(
                'is_safe' => array(
                    'html'
                )
            ))
        );
    }

    /**
     * Generate Js function to send ajax request.
     *
     * @param array $options            
     */
    public function remoteCall($options = array())
    {
        return function ($options) {
            $type = isset($options['type']) ? $options['type'] : "POST";
            $dataType = isset($options['dataType']) ? $options['dataType'] : "html";
            $js = "$.ajax({
							url: '" . $options['url'] . "',
							type: '" . $type . "',
							dataType: '" . $dataType . "',";
            
            if (isset($options['before'])) {
                $before = str_replace('"', "'", $options['before']);
                $js .= "beforeSend: function(){" . $before . "},";
            }
            
            $js .= "success: function( data ){ $('" . $options['update'] . "').html(data);";
            
            if (isset($options['after'])) {
                $after = str_replace('"', "'", $options['after']);
                $js .= $after;
            }
            
            $js .= "}";
            
            if (isset($options['complete'])) {
                $complete = str_replace('"', "'", $options['complete']);
                $js .= ",complete: function(){" . $complete . "},";
            }
            
            $js .= "});";
            
            return $js;
        };
    }

    /**
     * Generate link tag with js function to send ajax request
     *
     * @param array $options            
     */
    public function linkTag($options = array())
    {
        $jsRequest = $this->remoteCall();
        
        return function ($options) use($jsRequest)
        {
            $confirm = '';
            if (isset($options['confirm']) && $options['confirm'] == true) {
                
                $msg = "Are you sure you want to perform this action?";
                if(isset($options['confirm_msg'])) {
                    $msg = htmlentities(str_replace("'", '"', $options['confirm_msg']), ENT_QUOTES);                  
                }
            	$confirm .= "if(confirm('".$msg."'))" ;
            }
            $html = '<a class="' . (isset($options['class']) ? $options['class'] : "") . '"
    		 		 id="' . (isset($options['id']) ? $options['id'] : "") . '"
    		 		 href="' . $options['url'] . '"
    				 onclick="' .$confirm. call_user_func($jsRequest, $options) . 'return false;">';
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
