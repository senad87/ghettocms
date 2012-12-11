<?php 



public function do_newsletter($params=array()){
			
			$newsletter = new Newsletter();
			
			if($params[0] == "subscribe"){
			       
			
			       
			       $email = $this->params->getParam(PARAM_POST, "email", "string");
			       $md5_email = md5($email);
			  	
				if(!stristr($email,"@") OR !stristr($email,".")){
					$msg_is_valid = "NOT_valid";
				} 
				else
				{
					$msg_is_valid = "valid";
				}
				
				if($newsletter->isAlreadySubscribed($md5_email)){
					$msg_already_subscribed = "YES";
					
				}
				else
				{
					$msg_already_subscribed = "NO";
				}
					
				
				if($msg_is_valid == "valid" && $msg_already_subscribed == "NO" ){
					
					//var_dump($md5_email);
					$import = $newsletter->importNewsletterEmail($email, $md5_email);
					$msg = "thanks_for_subscribing";
				}
				elseif($msg_is_valid == "NOT_valid"){
					$msg = "email_not_valid_check_typing";
				}
				elseif($msg_already_subscribed == "YES"){
					$msg = "you_are_already_subscribed";
				}
				$this->smarty->assign("msg", $msg);
				$this->smarty->display("xhtml_newslett_subscribe.tpl");
			}
			elseif($params[0] == "unsubscribe"){
			
				$md5_email = $params[1];
				
				$unsubscribe = $newsletter->unsubscribe($md5_email);
				$msg = "you_have_successfully_unsubscribed";
				
				$this->smarty->assign("msg", $msg);
				$this->smarty->display("xhtml_newslett_Unsubscribe.tpl");
			}
			else
			{
			$this->smarty->display("xhtml_newslett_subscribe.tpl");	
			}
		}
