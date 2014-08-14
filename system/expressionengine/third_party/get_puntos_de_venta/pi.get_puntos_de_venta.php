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
    'pi_name'         => 'Get Puntos de Venta',
    'pi_version'      => '1.0',
    'pi_author'       => 'Gianfranco Montoya',
    'pi_author_url'   => 'http://www.ayuinc.com/',
    'pi_description'  => 'Permite enviar los puntos de venta almacenados en la base de datos',
    'pi_usage'        => Get_puntos_de_venta::usage()
);
            
class Get_puntos_de_venta 
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
        Para usar el este plugin debes 
        llamarlo con el siguiente tag

            {exp:get_puntos_de_venta:Nombre_de_la_función}

        Es lo único que se necesita para ejecutar
        una función de este plugin.
            <?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
    // END

    public function agency(){
        $div = '';
        $district = ee()->TMPL->fetch_param('distrito');
        ee()->db->select('*');
        ee()->db->where('distrito',$district);
        $query = ee()->db->get('exp_agencias');
        foreach($query->result() as $row){
            $div .='<div class="result">';
            $div .= '<p>'.$row->oficina.'</p>';
            $div .= '<p>'.$row->direccion.'</p>';
            $div .= '<p>'.$row->ubicacion.'</p>';
            $div .= '</div>';
        }
        return $div;


    }
} 
/* End of file pi.rating.php */
/* Location: ./system/expressionengine/third_party/rating/pi.rating.php */