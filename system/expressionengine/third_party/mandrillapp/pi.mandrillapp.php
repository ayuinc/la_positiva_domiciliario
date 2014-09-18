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

	function send_email_positiva(){
	global $TMPL;
	$this->EE =& get_instance(); // EEv2 syntax
	$TMPL = $this->EE->TMPL;

	require_once 'mailchimp-mandrill-api-php/src/Mandrill.php'; 
	$mandrill = new Mandrill('hubmcjT8BI95RjWPedg1LA');

	$to = ee()->TMPL->fetch_param('email_to');
	$name = ee()->TMPL->fetch_param('name');
	$from = ee()->TMPL->fetch_param('email_from');
	$email_client = ee()->TMPL->fetch_param('email_client');
	$phone = ee()->TMPL->fetch_param('phone');
	$housing_value = ee()->TMPL->fetch_param('housing_value');
	$housing_type = ee()->TMPL->fetch_param('housing_type');
	$province = ee()->TMPL->fetch_param('province');
	$city = ee()->TMPL->fetch_param('city');
  $plan_id = ee()->TMPL->fetch_param('plan_id');

	$subject= "Cotización Seguro Domiciliario.";

	$query_provincia = ee()->db->select('*')->from('exp_provincia')->where('id',$province)->get();
	$resultado_provincia = $query_provincia->result();	
  $provincia = $resultado_provincia[0]->name;

  $query_ciudad = ee()->db->select('*')->from('exp_ciudad')->where('id',$city)->get();
	$resultado_ciudad = $query_ciudad->result();	
  $ciudad = $resultado_ciudad[0]->name;

  switch ($housing_value) {
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
      case 7:
          $rango = 'S/.600,000 - a más';          
          break;
  }

	$text = 'Por favor contactar al usuario '.$name.' al teléfono '.$phone.'. 
	El usuario ha realizado la siguiente cotización del seguro Domiciliario:<br>
	<br><b>Datos de la vivienda:</b><br>';

  $text .= '<ul>';
  // $text .= '<li>Plan : '.$row->name.'</li>';
  $text .= '<li>Rango de precio de vivienda : '.$rango.'</li>';
  $text .= '<li>Tipo de vivienda : '.$housing_type.'</li>';
  $text .= '<li>Provincia : '.$provincia.'</li>';
  $text .= '<li>Distrito : '.$ciudad.'</li>';
  $text .= '</ul>';

	$text .= '<b>Datos del plan cotizado:</b><br>';

  if ($plan_id != '13') {

	$query_planes = ee()->db->select('*')->from('exp_planes_domiciliario')->where('id',$plan_id)->get();

	  foreach($query_planes->result() as $row){
	      $robo = '';
	      if ($row->theft == 1) {
	          $robo = 'Sí';
	      }else{
	          $robo = 'No';
	      };
	      $text .= '<ul>';
	      // $text .= '<li>Plan : '.$row->name.'</li>';
	      $text .= '<li>'.$row->coverage_1_description.' : hasta S/.'.$row->coverage_1.'</li>';
	      $text .= '<li>'.$row->coverage_2_description.' : hasta S/.'.$row->coverage_2.'</li>';
	      $text .= '<li>'.$row->coverage_3_description.' : hasta S/.'.$row->coverage_3.'</li>';
	      $text .= '<li>'.$row->coverage_4_description.' : hasta S/.'.$row->coverage_4.'</li>';
	      $text .= '<li>'.$row->coverage_5_description.' : hasta S/.'.$row->coverage_5.'</li>';
	      $text .= '<li>Con robo : '.$robo.'</li>';
	      $text .= '<li>Prima : '.$row->price.' mensuales</li>';
	      $text .= '</ul>';
	  }
  }else{
  	$text .= '<ul>';
  	$text .= '<li> valor de vivienda: S/. 600,000 a más</li>';
  	$text .= '<ul>';
  }

	$text .='<br>En caso no puedan contactarlo por teléfono, por favor escribirle al correo <b>'.$email_client.'</b>';
	
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

	function send_email_client(){
	global $TMPL;
	$this->EE =& get_instance(); // EEv2 syntax
	$TMPL = $this->EE->TMPL;

	require_once 'mailchimp-mandrill-api-php/src/Mandrill.php'; 
	$mandrill = new Mandrill('hubmcjT8BI95RjWPedg1LA');

	$to = ee()->TMPL->fetch_param('email_to');
	$name = ee()->TMPL->fetch_param('name');
	$from = ee()->TMPL->fetch_param('email_from');
	$housing_value = ee()->TMPL->fetch_param('housing_value');
	$housing_type = ee()->TMPL->fetch_param('housing_type');
	$province = ee()->TMPL->fetch_param('province');
	$city = ee()->TMPL->fetch_param('city');	
	$plan_id = ee()->TMPL->fetch_param('plan_id');

	$subject= "Cotización Seguro Domiciliario.";

	$query_provincia = ee()->db->select('*')->from('exp_provincia')->where('id',$province)->get();
	$resultado_provincia = $query_provincia->result();	
  $provincia = $resultado_provincia[0]->name;

  $query_ciudad = ee()->db->select('*')->from('exp_ciudad')->where('id',$city)->get();
	$resultado_ciudad = $query_ciudad->result();	
  $ciudad = $resultado_ciudad[0]->name;


  switch ($housing_value) {
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
      case 7:
          $rango = 'S/.600,000 - a más';               
  }

	$text = 'Hola '.$name.',<br>
		Muchas gracias por cotizar tu Seguro Domiciliario de La Positiva.<br>
    <br>
    Lleva tu cotización a cualquier punto de venta de La Positiva y adquiere tu seguro en un instante.<br>
    <br>
    Los detalles de tu cotización son los siguientes:<br>
    <br><b>Datos de la vivienda:</b><br>';
	

  $text .= '<ul>';
  // $text .= '<li>Plan : '.$row->name.'</li>';
  $text .= '<li>Rango de precio de vivienda : '.$rango.'</li>';
  $text .= '<li>Tipo de vivienda : '.$housing_type.'</li>';
  $text .= '<li>Provincia : '.$provincia.'</li>';
  $text .= '<li>Distrito : '.$ciudad.'</li>';
  $text .= '</ul>';

  if ($plan_id != '13') {

		$text .= '<b>Datos del plan cotizado:</b><br>';

		$query_planes = ee()->db->select('*')->from('exp_planes_domiciliario')->where('id',$plan_id)->get();

	  foreach($query_planes->result() as $row){
	      $robo = '';
	      if ($row->theft == 1) {
	          $robo = 'Sí';
	      }else{
	          $robo = 'No';
	      };
	      $text .= '<ul>';
	      // $text .= '<li>Plan : '.$row->name.'</li>';
	      $text .= '<li>'.$row->coverage_1_description.' : hasta S/.'.$row->coverage_1.'</li>';
	      $text .= '<li>'.$row->coverage_2_description.' : hasta S/.'.$row->coverage_2.'</li>';
	      $text .= '<li>'.$row->coverage_3_description.' : hasta S/.'.$row->coverage_3.'</li>';
	      $text .= '<li>'.$row->coverage_4_description.' : hasta S/.'.$row->coverage_4.'</li>';
	      $text .= '<li>'.$row->coverage_5_description.' : hasta S/.'.$row->coverage_5.'</li>';
	      $text .= '<li>Con robo : '.$robo.'</li>';
	      $text .= '<li>Precio : '.$row->price.'</li>';
	      $text .= '</ul>';
	  }

  }
	$text .='<br>Si tienes alguna duda o si este correo te ha llegado sin haber realizado una cotización en línea, por favor escríbenos al siguiente correo: lineapositiva@lapositiva.com o llámanos al 211-0212 desde Lima o al 749001 desde provincias.<br>';
	$text .='<br>Muchas gracias,</br>';
	$text .='<br>El equipo de La Positiva Seguros</br>';
	$text .='<br>www.lapositiva.com.pe</br>';
	
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