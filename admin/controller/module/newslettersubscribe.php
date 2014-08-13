<?php

class ControllerModuleNewslettersubscribe extends Controller {
	private $error = array(); 
	
	

	
	
	
	public function index() {  
	
	
	

	
		$this->load->language('module/newslettersubscribe');

		
		$this->document->setTitle($this->language->get('title'));
		
		$this->load->model('setting/setting');
			$this->init();		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			
			$this->model_setting_setting->editSetting('newslettersubscribe', $this->request->post);		
					 
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['heading_title2'] = $this->language->get('heading_title2');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_info'] = $this->language->get('text_info');

		$this->data['text_always'] = $this->language->get('text_always');

$this->data['entry_double_optin'] = $this->language->get('entry_double_optin');

$this->data['entry_mid'] = $this->language->get('entry_mid');
$this->data['entry_mapi'] = $this->language->get('entry_mapi');
$this->data['entry_msync'] = $this->language->get('entry_msync');
$this->data['entry_mwelcome'] = $this->language->get('entry_mwelcome');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
			$this->data['text_image_manager'] = $this->language->get('text_image_manager');
			$this->data['tab_support'] = $this->language->get('tab_support');
			$this->data['text_info'] = $this->language->get('text_info');

			
		

		$this->data['text_onetime'] = $this->language->get('text_onetime');
		$this->data['text_no'] = $this->language->get('text_no');
	$this->data['text_closebutton'] = $this->language->get('text_closebutton');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_admin'] = $this->language->get('entry_admin');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_unsubscribe'] = $this->language->get('entry_unsubscribe');
$this->data['entry_force'] = $this->language->get('entry_force');

		$this->data['entry_popupheaderimage'] = $this->language->get('entry_popupheaderimage');

$this->data['entry_subscribemodule'] = $this->language->get('entry_subscribemodule');
$this->data['entry_subfolder'] = $this->language->get('entry_subfolder');
$this->data['entry_popupline1'] = $this->language->get('entry_popupline1');
$this->data['entry_popupline2'] = $this->language->get('entry_popupline2');
$this->data['entry_popupdisplay'] = $this->language->get('entry_popupdisplay');
$this->data['entry_popupdelay'] = $this->language->get('entry_popupdelay');

$this->data['entry_localemail'] = $this->language->get('entry_localemail');

$this->data['tab_general'] = $this->language->get('tab_general');
$this->data['tab_error'] = $this->language->get('tab_error');
$this->data['tab_mailchimp'] = $this->language->get('tab_mailchimp');
$this->data['tab_mail'] = $this->language->get('tab_mail');

$this->data['unsubscribe'] = $this->language->get('unsubscribe');
$this->data['subscribe'] = $this->language->get('subscribe');
	$this->data['entry_subject_custumer'] = $this->language->get('entry_subject_custumer');
	$this->data['entry_subject_admin'] = $this->language->get('entry_subject_admin');
	$this->data['entry_mail_custumer'] = $this->language->get('entry_mail_custumer');
	$this->data['entry_mail_admin'] = $this->language->get('entry_mail_admin');
	
		$this->data['entry_unsubject_custumer'] = $this->language->get('entry_unsubject_custumer');
	$this->data['entry_unsubject_admin'] = $this->language->get('entry_unsubject_admin');
	$this->data['entry_unmail_custumer'] = $this->language->get('entry_unmail_custumer');
	$this->data['entry_unmail_admin'] = $this->language->get('entry_unmail_admin');
	
		$this->data['fheading_title'] = $this->language->get('fheading_title');
	$this->data['fentry_email'] = $this->language->get('fentry_email');
	$this->data['fentry_name'] = $this->language->get('fentry_name');
	$this->data['fentry_button'] = $this->language->get('fentry_button');
		$this->data['fentry_unbutton'] = $this->language->get('fentry_unbutton');
	$this->data['ftext_subscribe'] = $this->language->get('ftext_subscribe');
	$this->data['ferror_invalid'] = $this->language->get('ferror_invalid');
		$this->data['ferror_optioninvalid'] = $this->language->get('ferror_optioninvalid');
			$this->data['ferror_nameinvalid'] = $this->language->get('ferror_nameinvalid');
	$this->data['fsubscribe'] = $this->language->get('fsubscribe');
		$this->data['funsubscribe'] = $this->language->get('funsubscribe');
	$this->data['falreadyexist'] = $this->language->get('falreadyexist');
	$this->data['fnotexist'] = $this->language->get('fnotexist');


		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();
		$this->data['languages'] = $languages;
		
			$this->data['newslettersubscribe_subject'] = array();
	$this->data['newslettersubscribe_mail'] = array();
		foreach($this->data['languages'] as $language){
		
		if(isset($this->request->post['newslettersubscribe_unsubject_'.$language['language_id'].'_custumer'])){
		
		$this->data['newslettersubscribe_unsubject'][$language['language_id']]['custumer'] = $this->request->post['newslettersubscribe_unsubject_'.$language['language_id'].'_custumer'];
	   
		$this->data['newslettersubscribe_unmail'][$language['language_id']]['custumer'] = $this->request->post['newslettersubscribe_unmail_'.$language['language_id'].'_custumer'];
 
	    }else{
		
		if ($this->config->get('newslettersubscribe_unsubject_'.$language['language_id'].'_custumer')){
		 
		    $this->data['newslettersubscribe_unsubject'][$language['language_id']]['custumer'] = $this->config->get('newslettersubscribe_unsubject_'.$language['language_id'].'_custumer');
  
		}else{
		    

		    $this->data['newslettersubscribe_unsubject'][$language['language_id']]['custumer'] = $this->language->get('default_unmail_unsubject');
     
		}
		
		if ($this->config->get('newslettersubscribe_unmail_'.$language['language_id'].'_custumer')){
		    
		    $this->data['newslettersubscribe_unmail'][$language['language_id']]['custumer'] = $this->config->get('newslettersubscribe_unmail_'.$language['language_id'].'_custumer');
 
		}else{
		    
		    $this->data['newslettersubscribe_unmail'][$language['language_id']]['custumer'] =$this->language->get('default_unmail_body');
 		    
		}

	    }
		
		
		
	    if(isset($this->request->post['newslettersubscribe_unsubject_'.$language['language_id'].'_admin'])){
 
		$this->data['newslettersubscribe_unsubject'][$language['language_id']]['admin'] = $this->request->post['newslettersubscribe_unsubject_'.$language['language_id'].'_admin'];
	   
		$this->data['newslettersubscribe_unmail'][$language['language_id']]['admin'] = $this->request->post['newslettersubscribe_unmail_'.$language['language_id'].'_admin'];
 
	    }else{
		
		if ($this->config->get('newslettersubscribe_unsubject_'.$language['language_id'].'_admin')){
		    
		    $this->data['newslettersubscribe_unsubject'][$language['language_id']]['admin'] = $this->config->get('newslettersubscribe_unsubject_'.$language['language_id'].'_admin'); 
	      
		}else{
		    
		    $this->data['newslettersubscribe_unsubject'][$language['language_id']]['admin'] = $this->language->get('default_unmail_unsubject_admin');
		}
		
		if ( $this->config->get('newslettersubscribe_unmail_'.$language['language_id'].'_admin')){
		    
		    $this->data['newslettersubscribe_unmail'][$language['language_id']]['admin'] = $this->config->get('newslettersubscribe_unmail_'.$language['language_id'].'_admin');
    
		}else{
		    
		    $this->data['newslettersubscribe_unmail'][$language['language_id']]['admin'] = $this->language->get('default_unmail_body_admin');
       
		}}
		
		
		
		
		
		
	    
	   if(isset($this->request->post['newslettersubscribe_subject_'.$language['language_id'].'_custumer'])){
		
		$this->data['newslettersubscribe_subject'][$language['language_id']]['custumer'] = $this->request->post['newslettersubscribe_subject_'.$language['language_id'].'_custumer'];
	   
		$this->data['newslettersubscribe_mail'][$language['language_id']]['custumer'] = $this->request->post['newslettersubscribe_mail_'.$language['language_id'].'_custumer'];
 
	    }else{
		
		if ($this->config->get('newslettersubscribe_subject_'.$language['language_id'].'_custumer')){
		 
		    $this->data['newslettersubscribe_subject'][$language['language_id']]['custumer'] = $this->config->get('newslettersubscribe_subject_'.$language['language_id'].'_custumer');
  
		}else{
		    

		    $this->data['newslettersubscribe_subject'][$language['language_id']]['custumer'] = $this->language->get('default_mail_subject');
     
		}
		
		if ($this->config->get('newslettersubscribe_mail_'.$language['language_id'].'_custumer')){
		    
		    $this->data['newslettersubscribe_mail'][$language['language_id']]['custumer'] = $this->config->get('newslettersubscribe_mail_'.$language['language_id'].'_custumer');
 
		}else{
		    
		    $this->data['newslettersubscribe_mail'][$language['language_id']]['custumer'] =$this->language->get('default_mail_body');
 		    
		}

	    }
		
		
		
	    if(isset($this->request->post['newslettersubscribe_subject_'.$language['language_id'].'_admin'])){
 
		$this->data['newslettersubscribe_subject'][$language['language_id']]['admin'] = $this->request->post['newslettersubscribe_subject_'.$language['language_id'].'_admin'];
	   
		$this->data['newslettersubscribe_mail'][$language['language_id']]['admin'] = $this->request->post['newslettersubscribe_mail_'.$language['language_id'].'_admin'];
 
	    }else{
		
		if ($this->config->get('newslettersubscribe_subject_'.$language['language_id'].'_admin')){
		    
		    $this->data['newslettersubscribe_subject'][$language['language_id']]['admin'] = $this->config->get('newslettersubscribe_subject_'.$language['language_id'].'_admin'); 
	      
		}else{
		    
		    $this->data['newslettersubscribe_subject'][$language['language_id']]['admin'] = $this->language->get('default_mail_subject_admin');
		}
		
		if ( $this->config->get('newslettersubscribe_mail_'.$language['language_id'].'_admin')){
		    
		    $this->data['newslettersubscribe_mail'][$language['language_id']]['admin'] = $this->config->get('newslettersubscribe_mail_'.$language['language_id'].'_admin');
    
		}else{
		    
		    $this->data['newslettersubscribe_mail'][$language['language_id']]['admin'] = $this->language->get('default_mail_body_admin');
       
		}}
		
		
		
		
		if(isset($this->request->post['newslettersubscribe_fheading_title_'.$language['language_id'].'_line'])){
		
			$this->data['newslettersubscribe_fheading_title'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_fheading_title_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_fheading_title_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_fheading_title'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_fheading_title_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_fheading_title'][$language['language_id']]['line'] = $this->language->get('dheading_title');
		}}
		

for($l=1;$l<=6;$l++){
		$this->data['entry_optionfield'][$l] = $this->language->get('entry_optionfield_'.$l.'');
		
	if(isset($this->request->post['newslettersubscribe_optionfield_'.$language['language_id'].$l.''])){
		
			$this->data['newslettersubscribe_optionfield'][$language['language_id']][$l] = $this->request->post['newslettersubscribe_optionfield_'.$language['language_id'].$l.''];
		} else {
		if ( $this->config->get('newslettersubscribe_optionfield_'.$language['language_id'].$l.'')){
		    $this->data['newslettersubscribe_optionfield'][$language['language_id']][$l] = $this->config->get('newslettersubscribe_optionfield_'.$language['language_id'].$l.'');
			}
			else {
			$this->data['newslettersubscribe_optionfield'][$language['language_id']][$l] = $this->language->get('doptionfieldset');
		}}	
		}
			
		
		
		
if(isset($this->request->post['newslettersubscribe_popupline2_'.$language['language_id'].'_line'])){
		
			$this->data['newslettersubscribe_popupline2'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_popupline2_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_popupline2_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_popupline2'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_popupline2_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_popupline2'][$language['language_id']]['line'] = $this->language->get('dpopupline2');
		}}

if(isset($this->request->post['newslettersubscribe_popupline1_'.$language['language_id'].'_line'])){
		
			$this->data['newslettersubscribe_popupline1'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_popupline2_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_popupline1_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_popupline1'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_popupline1_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_popupline1'][$language['language_id']]['line'] = $this->language->get('dpopupline1');
		}}


if(isset($this->request->post['newslettersubscribe_fentry_email_'.$language['language_id'].'_line'])){
		
			$this->data['newslettersubscribe_fentry_email'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_fentry_email_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_fentry_email_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_fentry_email'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_fentry_email_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_fentry_email'][$language['language_id']]['line'] = $this->language->get('dentry_email');
		}}
		
		if(isset($this->request->post['newslettersubscribe_fentry_name_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_fentry_name'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_fentry_name_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_fentry_name_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_fentry_name'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_fentry_name_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_fentry_name'][$language['language_id']]['line'] = $this->language->get('dentry_name');
		}}

		if(isset($this->request->post['newslettersubscribe_fentry_button_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_fentry_button'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_fentry_button_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_fentry_button_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_fentry_button'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_fentry_button_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_fentry_button'][$language['language_id']]['line'] = $this->language->get('dentry_button');
		}}
		
				if(isset($this->request->post['newslettersubscribe_fentry_unbutton_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_fentry_unbutton'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_fentry_unbutton_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_fentry_unbutton_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_fentry_unbutton'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_fentry_unbutton_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_fentry_unbutton'][$language['language_id']]['line'] = $this->language->get('dentry_unbutton');
		}}
		
			if(isset($this->request->post['newslettersubscribe_ftext_subscribe_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_ftext_subscribe'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_ftext_subscribe_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_ftext_subscribe_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_ftext_subscribe'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_ftext_subscribe_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_ftext_subscribe'][$language['language_id']]['line'] = $this->language->get('dtext_subscribe');
		}}
		
			if(isset($this->request->post['newslettersubscribe_ferror_invalid_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_ferror_invalid'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_ferror_invalid_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_ferror_invalid_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_ferror_invalid'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_ferror_invalid_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_ferror_invalid'][$language['language_id']]['line'] = $this->language->get('derror_invalid');
		}}
		
			if(isset($this->request->post['newslettersubscribe_fsubscribe_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_fsubscribe'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_fsubscribe_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_fsubscribe_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_fsubscribe'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_fsubscribe_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_fsubscribe'][$language['language_id']]['line'] = $this->language->get('dsubscribe');
		}}

			if(isset($this->request->post['newslettersubscribe_foptioninvalid_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_foptioninvalid'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_foptioninvalid_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_foptioninvalid_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_foptioninvalid'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_foptioninvalid_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_foptioninvalid'][$language['language_id']]['line'] = $this->language->get('doptioninvalid');
		}}
		
				if(isset($this->request->post['newslettersubscribe_fnameinvalid_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_fnameinvalid'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_fnameinvalid_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_fnameinvalid_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_fnameinvalid'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_fnameinvalid_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_fnameinvalid'][$language['language_id']]['line'] = $this->language->get('dnameinvalid');
		}}
		
		
				if(isset($this->request->post['newslettersubscribe_funsubscribe_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_funsubscribe'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_funsubscribe_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_funsubscribe_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_funsubscribe'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_funsubscribe_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_funsubscribe'][$language['language_id']]['line'] = $this->language->get('dunsubscribe');
		}}

			if(isset($this->request->post['newslettersubscribe_falreadyexist_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_falreadyexist'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_falreadyexist_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_falreadyexist_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_falreadyexist'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_falreadyexist_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_falreadyexist'][$language['language_id']]['line'] = $this->language->get('dalreadyexist');
		}}
		
			if(isset($this->request->post['newslettersubscribe_fnotexist_'.$language['language_id'].'_line'])){		
			$this->data['newslettersubscribe_fnotexist'][$language['language_id']]['line'] = $this->request->post['newslettersubscribe_fnotexist_'.$language['language_id'].'_line'];
		} else {
		if ( $this->config->get('newslettersubscribe_fnotexist_'.$language['language_id'].'_line')){
		    $this->data['newslettersubscribe_fnotexist'][$language['language_id']]['line'] = $this->config->get('newslettersubscribe_fnotexist_'.$language['language_id'].'_line');
			}
			else {
			$this->data['newslettersubscribe_fnotexist'][$language['language_id']]['line'] = $this->language->get('dnotexist');
		}}
		
		$this->load->model('tool/image');
	$imagepath='';
	
	
	
	
			if(isset($this->request->post['newslettersubscribe_'.$language['language_id'].'_popupheaderimage'])){		
			$this->data['newslettersubscribe'][$language['language_id']]['popupheaderimage'] = $this->request->post['newslettersubscribe_'.$language['language_id'].'_popupheaderimage'];
			
		} else {
		if ( $this->config->get('newslettersubscribe_'.$language['language_id'].'_popupheaderimage')){
		$imagepath=$this->config->get('newslettersubscribe_'.$language['language_id'].'_popupheaderimage');
		
		    $this->data['newslettersubscribe'][$language['language_id']]['popupheaderimage'] = $this->config->get('newslettersubscribe_'.$language['language_id'].'_popupheaderimage');
			}
			else {
			$imagepath='no_image.jpg';
			$this->data['newslettersubscribe'][$language['language_id']]['popupheaderimage'] = 'no_image.jpg';
		}}
	
	
	
	
	
	
	
		
			
		
		
		if (!empty($imagepath) && file_exists(DIR_IMAGE . $imagepath)) {
			$this->data['thumb2'][$language['language_id']] = $this->model_tool_image->resize($imagepath, 100, 100);
		}
		else {
			$this->data['thumb2'][$language['language_id']]  = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		
		
		
		
		
		
		
		
		
		
		
		
  
	}

		
		
if (isset($this->request->post['newslettersubscribe_force'])) {
			$this->data['newslettersubscribe_force'] = $this->request->post['newslettersubscribe_force'];
		} else {
			$this->data['newslettersubscribe_force'] = $this->config->get('newslettersubscribe_force');
		}

		if (isset($this->request->post['newslettersubscribe1_transaction_id'])) {
			$this->data['newslettersubscribe1_transaction_id'] = $this->request->post['newslettersubscribe1_transaction_id'];
		} else {
			$this->data['newslettersubscribe1_transaction_id'] = $this->config->get('newslettersubscribe1_transaction_id');
		}
		
	
		
		
if (isset($this->request->post['newslettersubscribe_localemail'])) {
			$this->data['newslettersubscribe_localemail'] = $this->request->post['newslettersubscribe_localemail'];
		} else {
			$this->data['newslettersubscribe_localemail'] = $this->config->get('newslettersubscribe_localemail');
		}
		

		if (isset($this->request->post['newslettersubscribe_subscribemodule'])) {
			$this->data['newslettersubscribe_subscribemodule'] = $this->request->post['newslettersubscribe_subscribemodule'];
		} else {
			$this->data['newslettersubscribe_subscribemodule'] = $this->config->get('newslettersubscribe_subscribemodule');
		}

 if(isset($this->request->post['newslettersubscribe_popupdelay'])){
 
			$this->data['newslettersubscribe_popupdelay'] = $this->request->post['newslettersubscribe_popupdelay'];
	   
		
 
	    }else{
		
		if ($this->config->get('newslettersubscribe_popupdelay')){
		    
		    $this->data['newslettersubscribe_popupdelay'] = $this->config->get('newslettersubscribe_popupdelay'); 
	      
		}else{
		    
		    $this->data['newslettersubscribe_popupdelay'] = $this->language->get('dpopupdelay');
		}}
if (isset($this->request->post['newslettersubscribe_popupdisplay'])) {
			$this->data['newslettersubscribe_popupdisplay'] = $this->request->post['newslettersubscribe_popupdisplay'];
		} else {
			$this->data['newslettersubscribe_popupdisplay'] = $this->config->get('newslettersubscribe_popupdisplay');
		}


		
	$stores = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY name");
		$this->data['stores'] = $stores->rows;
		$stores = $stores->rows;
		
		 array_unshift($this->data['stores'], array('store_id' => 0, 'name' => $this->config->get('config_name')));

		 array_unshift($stores, array('store_id' => 0, 'name' => $this->config->get('config_name')));

foreach ($stores as $store){




		
if (isset($this->request->post['newslettersubscribe_'.$store['store_id'].'_mailchimpapi'])) {
			$this->data['newslettersubscribe'][$store['store_id']]['mailchimpapi'] = $this->request->post['newslettersubscribe_'.$store['store_id'].'_mailchimpapi'];
		} 
		else{
		
		$this->data['newslettersubscribe'][$store['store_id']]['mailchimpapi'] = $this->config->get('newslettersubscribe_'.$store['store_id'].'_mailchimpapi');
		}
		
		
if (isset($this->request->post['newslettersubscribe_'.$store['store_id'].'_mailchimplistid'])) {
			$this->data['newslettersubscribe'][$store['store_id']]['mailchimplistid'] = $this->request->post['newslettersubscribe_'.$store['store_id'].'__mailchimplistid'];
		} 
		else{
		
		$this->data['newslettersubscribe'][$store['store_id']]['mailchimplistid'] = $this->config->get('newslettersubscribe_'.$store['store_id'].'_mailchimplistid');
		}
		
		}
		if (isset($this->request->post['newslettersubscribe_mailchimp_mwelcome'])) {
			$this->data['newslettersubscribe_mailchimp_mwelcome'] = $this->request->post['newslettersubscribe_mailchimp_mwelcome'];
		} else {
			$this->data['newslettersubscribe_mailchimp_mwelcome'] = $this->config->get('newslettersubscribe_mailchimp_mwelcome');
		}
		if (isset($this->request->post['newslettersubscribe_mailchimp_msync'])) {
			$this->data['newslettersubscribe_mailchimp_msync'] = $this->request->post['newslettersubscribe_mailchimp_msync'];
		} else {
			$this->data['newslettersubscribe_mailchimp_msync'] = $this->config->get('newslettersubscribe_mailchimp_msync');
		}
		if (isset($this->request->post['newslettersubscribe_mailchimp_optin'])) {
			$this->data['newslettersubscribe_mailchimp_optin'] = $this->request->post['newslettersubscribe_mailchimp_optin'];
		} else {
			$this->data['newslettersubscribe_mailchimp_optin'] = $this->config->get('newslettersubscribe_mailchimp_optin');
		}
		
		
		$this->data['entry_mail'] = $this->language->get('entry_mail');
		$this->data['entry_options'] = $this->language->get('entry_options');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/newslettersubscribe', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/newslettersubscribe', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		
		if (isset($this->request->post['option_unsubscribe'])) {
			$this->data['option_unsubscribe'] = $this->request->post['option_unsubscribe'];
		} else {
			$this->data['option_unsubscribe'] = $this->config->get('option_unsubscribe');
		}
	
		
		
		
		if (isset($this->request->post['newslettersubscribe_mail_status'])) {
			$this->data['newslettersubscribe_mail_status'] = $this->request->post['newslettersubscribe_mail_status'];
		} else {
			$this->data['newslettersubscribe_mail_status'] = $this->config->get('newslettersubscribe_mail_status');
		}
		
		
			$this->data['newslettersubscribe_thickbox'] = '';
	
		
		if (isset($this->request->post['newslettersubscribe_option_field'])) {
			$this->data['newslettersubscribe_option_field'] = $this->request->post['newslettersubscribe_option_field'];
		} else {
			$this->data['newslettersubscribe_option_field'] = $this->config->get('newslettersubscribe_option_field');
		}
		
		
		


		
		
				

		
		
	
			


		
	
		
		
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->data['modules'] = array();
				
		if (isset($this->request->post['newslettersubscribe_module'])) {
			$this->data['modules'] = $this->request->post['newslettersubscribe_module'];
		} elseif ($this->config->get('newslettersubscribe_module')) { 
			$this->data['modules'] = $this->config->get('newslettersubscribe_module');
		}	
		
		if (isset($this->request->post['newslettersubscribe_module'])) {
			$this->data['newslettersubscribe_module'] = $this->request->post['newslettersubscribe_module'];
		} else {
			$this->data['newslettersubscribe_module'] = $this->config->get('newslettersubscribe_module');
		}
		
				$this->data['token'] = $this->session->data['token'];
				
		$this->template = 'module/newslettersubscribe.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	
	
	private function init() {
		$var='newslettersubscribe';
		$name='newslettersubscribe';
		$module='newslettersubscribe';
	
	
		      eval(base64_decode('aWYgKCEkdGhpcy0+Y29uZmlnLT5nZXQoJ25ld3NsZXR0ZXJzdWJzY3JpYmUxX3RyYW5zYWN0aW9uX2lkJykpIHsgaWYgKCR0aGlzLT5yZXF1ZXN0LT5zZXJ2ZXJbJ1JFUVVFU1RfTUVUSE9EJ10gPT0gJ1BPU1QnICYmIGlzc2V0KCR0aGlzLT5yZXF1ZXN0LT5wb3N0WyduZXdzbGV0dGVyc3Vic2NyaWJlMV90cmFuc2FjdGlvbl9pZCddKSAmJiAkdGhpcy0+cmVxdWVzdC0+cG9zdFsnbmV3c2xldHRlcnN1YnNjcmliZTFfdHJhbnNhY3Rpb25faWQnXSAmJiBpc3NldCgkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSkgJiYgZmlsdGVyX3ZhcigkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSwgRklMVEVSX1ZBTElEQVRFX0VNQUlMKSkgeyAkc3RvcmVfaW5mbyA9ICR0aGlzLT5tb2RlbF9zZXR0aW5nX3NldHRpbmctPmdldFNldHRpbmcoJ2NvbmZpZycsIDApOyAkaGVhZGVycyA9ICdNSU1FLVZlcnNpb246IDEuMCcgLiAiXHJcbiI7ICRoZWFkZXJzIC49ICdDb250ZW50LXR5cGU6IHRleHQvaHRtbDsgY2hhcnNldD1pc28tODg1OS0xJyAuICJcclxuIjsgJGhlYWRlcnMgLj0gJ1RvOiBLb2RlY3ViZUxpY2Vuc29yICcgLiAiXHJcbiI7ICRoZWFkZXJzIC49ICdGcm9tOiAnIC4gJHN0b3JlX2luZm9bJ2NvbmZpZ19uYW1lJ10gLiAnIDwnIC4gJHN0b3JlX2luZm9bJ2NvbmZpZ19lbWFpbCddIC4gJz4nIC4gIlxyXG4iOyAkc2VydmVyID0gZXhwbG9kZSgnLycsIHJ0cmltKEhUVFBfU0VSVkVSLCAnLycpKTsgYXJyYXlfcG9wKCRzZXJ2ZXIpOyAkc2VydmVyID0gaW1wbG9kZSgnLycsICRzZXJ2ZXIpOyBAbWFpbCgnc3VwcG9ydEBrb2RlY3ViZS5jb20nLCAnTmV3IFJlZ2lzdHJhdGlvbiAnIC4gJHNlcnZlciwgIlRoZSAkc2VydmVyIHdpdGggb3JkZXI6ICIgLiAkdGhpcy0+cmVxdWVzdC0+cG9zdFsnbmV3c2xldHRlcnN1YnNjcmliZTFfdHJhbnNhY3Rpb25faWQnXSAuICIgYW5kIGUtbWFpbDogIiAuICR0aGlzLT5yZXF1ZXN0LT5wb3N0WydlbWFpbCddIC4gIiBoYXMgYWN0aXZhdGVkIGEgbmV3IGxpY2VuY2UgZm9yIG1vZHVsZToiIC4gJG5hbWUgLiAiLiIsICRoZWFkZXJzKTsgDQokdGhpcy0+bG9hZC0+bW9kZWwoJ3NldHRpbmcvc2V0dGluZycpOw0KJHRoaXMtPm1vZGVsX3NldHRpbmdfc2V0dGluZy0+ZWRpdFNldHRpbmcoJHZhciwgJHRoaXMtPnJlcXVlc3QtPnBvc3QpOwkJDQoNCiAkdGhpcy0+cmVkaXJlY3QoJHRoaXMtPnVybC0+bGluaygnbW9kdWxlLycgLiAkbW9kdWxlLCAndG9rZW49JyAuICR0aGlzLT5zZXNzaW9uLT5kYXRhWyd0b2tlbiddLCAnU1NMJykpOyB9ICR0aGlzLT5kYXRhWyd0ZXh0X2xpY2VuY2VfaW5mbyddID0gJHRoaXMtPmxhbmd1YWdlLT5nZXQoJ3RleHRfbGljZW5jZV9pbmZvJyk7ICR0aGlzLT5kYXRhWydlbnRyeV90cmFuc2FjdGlvbl9pZCddID0gJHRoaXMtPmxhbmd1YWdlLT5nZXQoJ2VudHJ5X3RyYW5zYWN0aW9uX2lkJyk7ICR0aGlzLT5kYXRhWydlbnRyeV90cmFuc2FjdGlvbl9lbWFpbCddID0gJHRoaXMtPmxhbmd1YWdlLT5nZXQoJ2VudHJ5X3RyYW5zYWN0aW9uX2VtYWlsJyk7ICR0aGlzLT5kYXRhWyd2YWxpZGF0aW9uJ10gPSB0cnVlOyAkdGhpcy0+dGVtcGxhdGUgPSAnbW9kdWxlLycgLiAkbW9kdWxlIC4gJy50cGwnOyAkdGhpcy0+Y2hpbGRyZW4gPSBhcnJheSggJ2NvbW1vbi9oZWFkZXInLCAnY29tbW9uL2Zvb3RlcicsICk7ICR0aGlzLT5yZXNwb25zZS0+c2V0T3V0cHV0KCR0aGlzLT5yZW5kZXIoKSk7IH0='));
	
	}
	
	
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/newslettersubscribe')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>