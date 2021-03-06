<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Content {

        private $CI;

        public function __construct()
        {
            $this->CI =& get_instance();
        }

		public function getCSS($files = array())
		{
			$this->CI->load->helper('html');

			$cssFiles = array(
				'reset.css',
				'basic.css',
                'forms.css',
				'layout.css',
				'infoBubble.css'
			);

			$cssFiles = array_merge($cssFiles, $files);

			$html = '';

			foreach($cssFiles as $file)
			{
				$html.= link_tag(array(
					'href' => 'resources/css/'.$file,
					'rel' => 'stylesheet',
					'type' => 'text/css',
					'media' => 'screen'
				));
			}

			return $html;
		}

		public function getJS($files = array())
		{
			$jsFolder = base_url().'resources/js/';

			$jsFiles = array(
				$jsFolder.'third-party/mootools-core-1.3-full-nocompat-yc.js',
				$jsFolder.'third-party/mootools-more.js',
				$jsFolder.'Photos.js'		 
			);
			
			$count = count($files);
			
			if($count > 0)
			{
				for($i = 0; $i < $count; $i++)
				{
					$files[$i] = $jsFolder.$files[$i];
				}
			}

			return array_merge($jsFiles, $files);
		}

        public function getDate($date = false)
        {
            $this->CI->lang->load('basic', 'english');

            $day = date('j');
            $month = date('n');
    
            return $month.$this->CI->lang->line('date_month_suffix').$day.$this->CI->lang->line('date_day_suffix');
        }

        public function getLoginForm()
        {
			$this->CI->lang->load('basic', 'english');
            $this->CI->load->helper('form');

			$form = '<div id="LoginForm">';
			$form.= '<p>'.$this->CI->lang->line('login_text').'</p>';
			$form.= form_open('#', array(
				'id' => 'Login'
			));
			$form.= form_fieldset();
			$form.= form_label('username');
			$form.= form_input(array(
				'maxlength' => 20,
				'name' => 'username'
			));
			$form.= form_label('password');
			$form.= form_input(array(
				'maxlength' => 20,
				'name' => 'password',
				'type' => 'password'
			));
			$form.= form_submit('login_submit', $this->CI->lang->line('login_button'));
			$form.= form_fieldset_close();
			$form.= form_close();
			$form.= '</div>';

			return $form;
        }

        public function view($view, $data = array())
        {
            $this->CI->load->view('includes/head', $data);
			if(is_array($view))
			{
				foreach($view as $v)
				{
					$this->CI->load->view($v, $data);		
				}
			}
			else
			{
				$this->CI->load->view($view, $data);
			}
        }

    }

?>