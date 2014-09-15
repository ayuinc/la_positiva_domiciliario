<?php 

$plugin_info = array(
						'pi_name'			=> 'Mandrillapp',
						'pi_version'		=> '1.0',
						'pi_author'			=> 'Gianfranco Montoya',
						'pi_author_url'		=> 'http://ayuinc.com',
						'pi_description'	=> 'Envia mensajes usando el API de Mandrillapp - https://mandrillapp.com',
						'pi_usage'			=> Mandrillapp::usage()
					);

/**
 * Send_email class
 *
 * @package			ExpressionEngine
 * @category		Plugin
 * @author			Gianfranco Montoya
 * @copyright		Copyright (c) 2014 Engaging.net
 * @link			--
 */

class Mandrillapp {

	function usage()
	{
		ob_start(); 
		?>
			See the documentation at http://www.engaging.net/docs/send-email
		<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}

	function send_email(){
	global $TMPL;
	$this->EE =& get_instance(); // EEv2 syntax
	$TMPL = $this->EE->TMPL;

	require_once 'mailchimp-mandrill-api-php/src/Mandrill.php'; 
	$mandrill = new Mandrill('hubmcjT8BI95RjWPedg1LA');

	$to = ee()->TMPL->fetch_param('email_to');
	$name = ee()->TMPL->fetch_param('name');
	$from = ee()->TMPL->fetch_param('from');
	$subject= "Cotización Seguro Domiciliario.";

	$text = 'Estimado(a) '.$name.',<p>
	Cotización Seguro Domiciliario - La Positiva.<p>.
	<br>';

  $plan_id = ee()->TMPL->fetch_param('plan_id');
  ee()->db->where('id',$plan_id);
  $query = ee()->db->get('exp_planes_domiciliario');
  foreach($query->result() as $row){
      $robo = '';
      if ($row->theft == 1) {
          $robo = 'Sí';
      }else{
          $robo = 'No';
      };
      $text .= '<ul>';
      $text .= '<li>Plan : '.$row->name.'</li>';
      $text .= '<li>'.$row->coverage_1_description.' : hasta S/.'.$row->coverage_1.'</li>';
      $text .= '<li>'.$row->coverage_2_description.' : hasta S/.'.$row->coverage_2.'</li>';
      $text .= '<li>'.$row->coverage_3_description.' : hasta S/.'.$row->coverage_3.'</li>';
      $text .= '<li>'.$row->coverage_4_description.' : hasta S/.'.$row->coverage_4.'</li>';
      $text .= '<li>'.$row->coverage_5_description.' : hasta S/.'.$row->coverage_5.'</li>';
      $text .= '<li>Con robo : '.$robo.'</li>';
      $text .= '<li>Precio : '.$row->price.'</li>';
      $text .= '</ul>';
  }
	$text .='**No responder. Correo automático enviado desde el Portal La Positiva*<br>';
	
	/*'html' => '<p>FELICIDADES!!!</p><p>Ganaste el tema'.$topic.' ve a nuestro menú de temas y sigue participando</p>',*/
	$message = array(
	    'subject' => $subject,
	    'from_email' => $from,
	    'html' => $text,
	    'to' => array(array('email' => $to, 'name' => $name)),
	    'merge_vars' => array(array(
		        'rcpt' => 'recipient1@domain.com',
		        'vars' =>
		        array(
		            array(
		                'name' => 'FIRSTNAME',
		                'content' => 'Recipient 1 first name'),
		            array(
		                'name' => 'LASTNAME',
		                'content' => 'Last name')
		    ))));

	$template_name = 'test';

	$template_content = array(
	    array(
	        'name' => 'main',
	        'content' => 'Hi *|FIRSTNAME|* *|LASTNAME|*, thanks for signing up.'),
	    array(
	        'name' => 'footer',
	        'content' => 'Copyright 2012.')

	);
	$mandrill->messages->sendTemplate($template_name, $template_content, $message);
	// return '<p>Correo Enviado</p>';
	}

}
// END CLASS