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

    public function get_plan(){
        $plan_id = ee()->TMPL->fetch_param('plan_id');
        $form = '';
        ee()->db->where('id',$plan_id);
        $query = ee()->db->get('exp_planes_domiciliario');
        $resultado = $query->result();

        if ($resultado[0]->theft == 1) {
            $robo = 'Sí';
        }else{ $robo = 'No';}

        $variables = array(
          'coverage_1' => $resultado[0]->coverage_1,
          'coverage_2' => $resultado[0]->coverage_2,
          'coverage_3' => $resultado[0]->coverage_3,
          'coverage_4' => $resultado[0]->coverage_4,
          'coverage_5' => $resultado[0]->coverage_5,
          'precio'     => $resultado[0]->price,
          'robo'       => $robo
        );


        return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $variables);
    }    

    public function get_planes_por_monto(){
        $monto = ee()->TMPL->fetch_param('monto');

        switch ($monto) {
            case 1:
                $id_1 = 1;
                $id_2 = 2;
                break;            
            case 2:
                $id_1 = 3;
                $id_2 = 4;    
                break;
            case 3:
                $id_1 = 5;
                $id_2 = 6;
                break;
            case 4:
                $id_1 = 7;
                $id_2 = 8;
                break;
            case 5:
                $id_1 = 9;
                $id_2 = 10;
                break;
            case 6:
                $id_1 = 11;
                $id_2 = 12;
                break;
        }


        $hasta = '';
        $sin_robo = '';
        $con_robo = '';
        ee()->db->where('id',$id_1);
        ee()->db->or_where('id',$id_2);
        $query = ee()->db->get('exp_planes_domiciliario');
        $resultado = $query->result();
        $hasta = $resultado[0]->coverage_5;
        $price_sin_robo = $resultado[0]->price;
        $price_con_robo = $resultado[1]->price;
        $id_sin_robo = $resultado[0]->id;
        $id_con_robo = $resultado[1]->id;

        $variables[] = array(
          'hasta' => $hasta,
          'price_sin_robo' => $price_sin_robo,
          'price_con_robo' => $price_con_robo,
          'id_sin_robo' => $id_sin_robo,
          'id_con_robo' => $id_con_robo
        );

        return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $variables);
    }    
  

    public function get_rango_planes(){
        $rango_id = ee()->TMPL->fetch_param('rango_id');
        switch ($rango_id) {
            case 1:
                $rango = 'S/.10,000 - S/.55,000';
                break;            
            case 2:
                $rango = 'S/.55,000 - S/.115,000';
                break;
            case 3:
                $rango = 'S/.115,000 - S/.150,000';
                break;
            case 4:
                $rango = 'S/.150,000 - S/.300,000';
                break;
            case 5:
                $rango = 'S/.300,000 - S/.450,000';
                break;
            case 6:
                $rango = 'S/.450,000 - S/.600,000';
                break;
        }


        $variables[] = array(
          'rango' => $rango,
        );

        return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $variables);
    }    

  
} 
/* End of file pi.rating.php */
/* Location: ./system/expressionengine/third_party/rating/pi.rating.php */