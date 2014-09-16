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
    'pi_name'         => 'Get provincia and ciudad',
    'pi_version'      => '1.0',
    'pi_author'       => 'Fred',
    'pi_author_url'   => 'http://www.ayuinc.com/',
    'pi_description'  => 'Allows states qualify Friends',
    'pi_usage'        => Get_provincia_ciudad::usage()
);
            
class Get_provincia_ciudad 
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

    public function provincia(){
        $form = '<select name="provincia" id="provincia" class="form-control"> <option value="0">PROVINCIA</option>';
        ee()->db->order_by('name');
        $query = ee()->db->get('exp_provincia');
        foreach($query->result() as $row){
            $provincia_id=$row->id;
            $provincia_name= $row->name;
            $form .= '<option value='.$provincia_id.'>'.$provincia_name.'</option>';
        }
        $form = $form.'</select>';
        return $form;
    }

    public function ciudad(){
        $form = '<option value="CIUDAD" selected>CIUDAD</option>';
        $provincia_id = ee()->TMPL->fetch_param('provincia');
        ee()->db->where('provincia_id',$provincia_id);
        ee()->db->order_by('name');
        $query = ee()->db->get('exp_ciudad');
        foreach($query->result() as $row){
            $ciudad_id=$row->id;
            $ciudad_name= $row->name;
            $form .= '<option value='.$ciudad_id.'>'.$ciudad_name.'</option>';
        }
        return $form;
    }

  
} 
/* End of file pi.rating.php */
/* Location: ./system/expressionengine/third_party/rating/pi.rating.php */