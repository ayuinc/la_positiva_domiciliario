<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Memberlist Class
 *
 * @package     ExpressionEngine
 * @category        Plugin
 * @author      Gianfranco Montoya 
 * @copyright       Copyright (c) 2014, Gianfranco Montoya
 * @link        http://www.ayuinc.com/
 */

$plugin_info = array(
    'pi_name'         => 'Registro interesado',
    'pi_version'      => '1.0',
    'pi_author'       => 'Fred',
    'pi_author_url'   => 'http://www.ayuinc.com/',
    'pi_description'  => 'Allows states qualify Friends',
    'pi_usage'        => Registro_interesado::usage()
);
            
class Registro_interesado
{

    var $return_data = "";
    // --------------------------------------------------------------------

        /**
         * Memberlist
         *
         * This function returns a list of members
         *
         * @access  public
         * @return  string
         */
    public function __construct(){
        $this->EE =& get_instance();
        $var = $this->EE->input->post('count');
    }

    // --------------------------------------------------------------------

    /**
     * Usage
     *
     * This function describes how the plugin is used.
     *
     * @access  public
     * @return  string
     */
    public static function usage()
    {
        ob_start();  ?>
        The Memberlist Plugin simply outputs a
        list of 15 members of your site.

            {exp:get_provincia_ciudad}

        This is an incredibly simple Plugin.
            <?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
    // END

    public function registrar_interesado(){
        $housing_value=ee()->TMPL->fetch_param('housing_value');
        $housing_type=ee()->TMPL->fetch_param('housing_type');
        $province=ee()->TMPL->fetch_param('province');
        $city=ee()->TMPL->fetch_param('city');
        $name=ee()->TMPL->fetch_param('name');
        $last_name=ee()->TMPL->fetch_param('last_name');
        $email=ee()->TMPL->fetch_param('email');
        $dni=ee()->TMPL->fetch_param('dni');
        $phone=ee()->TMPL->fetch_param('phone');
        $id_seguro=ee()->TMPL->fetch_param('id_seguro');

        $data = array(
            'housing_value'=>$housing_value,
            'housing_type'=>$housing_type,
            'province'=>$province,
            'city'=>$city,
            'name'=>$name,
            'surname'=>$last_name,
            'email'=>$email,
            'dni'=>$dni,
            'phone'=>$phone,
            'id_seguro'=>$id_seguro
            );
        if(ee()->db->insert('exp_interesados_domiciliario', $data)){
            // return 'realizado';
        }else{
            return 'error';
        }


    }
  
} 
/* End of file pi.rating.php */
/* Location: ./system/expressionengine/third_party/rating/pi.rating.php */