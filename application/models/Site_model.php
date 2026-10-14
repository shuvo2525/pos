<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model {
    public function get_details(){
		$data=$this->data;

		//Validate This suppliers already exist or not
		$query=$this->db->query("select * from db_sitesettings order by id asc limit 1");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			/* QUERY 1*/
			$query=$query->row();
			$data['q_id']=$query->id;
            $data['site_name']=$query->site_name;
            $data['logo']=$query->logo;
            $data['sidebar_color']=!empty($query->sidebar_color) ? $query->sidebar_color : '#ffffff';
            $data['sidebar_font_color']=!empty($query->sidebar_font_color) ? $query->sidebar_font_color : '#1e293b';
            $data['sidebar_active_color']=!empty($query->sidebar_active_color) ? $query->sidebar_active_color : '#0284c7';
            $data['sidebar_submenu_color']=!empty($query->sidebar_submenu_color) ? $query->sidebar_submenu_color : '';
            $data['sidebar_submenu_hover_color']=!empty($query->sidebar_submenu_hover_color) ? $query->sidebar_submenu_hover_color : '';
			return $data;
		}
	}
	public function update_site(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
		//echo "<pre>";print_r($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));exit();
				
		
		$logo='';
		if(!empty($_FILES['logo']['name'])){
			$config['upload_path']          = './uploads/site/';
	        $config['allowed_types']        = 'gif|jpg|png';
	        $config['max_size']             = 500;
	        $config['max_width']            = 500;
	        $config['max_height']           = 500;

	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('logo'))
	        {
	                $error = array('error' => $this->upload->display_errors());
	                print($error['error']);
	                exit();
	        }
	        else
	        {
	        	   $logo_name=$this->upload->data('file_name');
	        		$logo=" ,logo='/uploads/site/$logo_name' ";
	        }
		}
        
		$change_return = (isset($change_return)) ? 1 : 0;
		$round_off = (isset($round_off)) ? 1 : 0;
		$sidebar_color = (!empty($sidebar_color)) ? $sidebar_color : '#ffffff';
		$sidebar_font_color = (!empty($sidebar_font_color)) ? $sidebar_font_color : '#1e293b';
		$sidebar_active_color = (!empty($sidebar_active_color)) ? $sidebar_active_color : '#0284c7';
		$sidebar_submenu_color = (!empty($sidebar_submenu_color)) ? $sidebar_submenu_color : '';
		$sidebar_submenu_hover_color = (!empty($sidebar_submenu_hover_color)) ? $sidebar_submenu_hover_color : '';
        $query1="update db_sitesettings set site_name='$site_name', sidebar_color='$sidebar_color', sidebar_font_color='$sidebar_font_color', sidebar_active_color='$sidebar_active_color', sidebar_submenu_color='$sidebar_submenu_color', sidebar_submenu_hover_color='$sidebar_submenu_hover_color' $logo where id=$q_id";
        $query1= $this->db->simple_query($query1);
      
		if ($query1){
		    return "success";
		}
		else{
		    return "failed";
		}
	}
}

/* End of file Site_model.php */
