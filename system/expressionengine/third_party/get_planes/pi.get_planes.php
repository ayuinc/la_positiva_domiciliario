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
    'pi_name'         => 'Get planes',
    'pi_version'      => '1.0',
    'pi_author'       => 'Fred',
    'pi_author_url'   => 'http://www.ayuinc.com/',
    'pi_description'  => 'Allows states qualify Friends',
    'pi_usage'        => Get_planes::usage()
);
            
class Get_planes
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

    public function planes(){
        $plan_id = ee()->TMPL->fetch_param('plan_id');
        $form = '';
        ee()->db->where('id',$plan_id);
        $query = ee()->db->get('exp_planes_domiciliario');
        foreach($query->result() as $row){
            $robo = '';
            if ($row->theft == 1) {
                $robo = 'Sí';
            }else{
                $robo = 'No';
            };
            $form .= '<ul>';
            $form .= '<li>Plan : '.$row->name.'</li>';
            $form .= '<li>'.$row->coverage_1_description.' : hasta S/.'.$row->coverage_1.'</li>';
            $form .= '<li>'.$row->coverage_2_description.' : hasta S/.'.$row->coverage_2.'</li>';
            $form .= '<li>'.$row->coverage_3_description.' : hasta S/.'.$row->coverage_3.'</li>';
            $form .= '<li>'.$row->coverage_4_description.' : hasta S/.'.$row->coverage_4.'</li>';
            $form .= '<li>'.$row->coverage_5_description.' : hasta S/.'.$row->coverage_5.'</li>';
            $form .= '<li>Con robo : '.$robo.'</li>';
            $form .= '<li>Precio : '.$row->price.'</li>';
            $form .= '</ul>';
        }
        return $form;
    }

    public function get_planes_por_monto(){
        $monto = ee()->TMPL->fetch_param('monto');

        if (($monto > 0) && ($monto <= 55000)) {
            $id_1 = 1;
            $id_2 = 2;
        }elseif (($monto > 55000) && ($monto <= 115000)) {
            $id_1 = 3;
            $id_2 = 4;            
        }elseif (($monto > 115000) && ($monto <= 150000)) {
            $id_1 = 5;
            $id_2 = 6;
        }elseif (($monto > 150000) && ($monto <= 300000)) {
            $id_1 = 7;
            $id_2 = 8;
        }elseif (($monto > 300000) && ($monto <= 450000)) {
            $id_1 = 9;
            $id_2 = 10;
        }elseif (($monto > 450000) && ($monto <= 600000)) {
            $id_1 = 11;
            $id_2 = 12;
        }

        $hasta = '';
        $form = '';
        ee()->db->where('id',$id_1);
        ee()->db->or_where('id',$id_2);
        $query = ee()->db->get('exp_planes_domiciliario');
        $resultado = $query->result();
        $form = $resultado(1);
        // foreach($query->result() as $row){
        //     $robo = '';
        //     if ($row->theft == 1) {
        //         $robo = 'Sí';
        //     }else{
        //         $robo = 'No';
        //     };

        //     $form .= '<ul>';
        //     $form .= '<li>Plan : '.$row->name.'</li>';
        //     $form .= '<li>Con robo : '.$robo.'</li>';
        //     $form .= '<li>Precio : '.$row->price.'</li>';
        //     $form .= '</ul>';
        // }
        return $form;
    }    
  
} 
/* End of file pi.rating.php */
/* Location: ./system/expressionengine/third_party/rating/pi.rating.php */